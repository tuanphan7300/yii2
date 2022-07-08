<?php

namespace app\controllers;

use app\models\Order;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\components\helper\PayonEncrypt;
use app\components\helper\helper;
use yii\db\Expression;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionProduct()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $id = $request->get('id');
        $model = Product::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('product', [
            'model' => $model,
        ]);
    }

    public function actionProductList()
    {
        $model = Product::find()->all();
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('productList', [
            'model' => $model,
        ]);
    }

    public function actionCheckPayment()
    {
        //get payment_token from response payon
        $payment_token = $_GET['payment_token'];

        //get merchant_request_id when create order from db
        $order = Order::find()->where(['payment_token' => $payment_token])->one();
        $merchant_request_id = $order->merchant_request_id;

        $data = array(
            'merchant_request_id' => $merchant_request_id
        );
        echo '<pre>';
        print_r("==> Param request:");
        print_r($data);
        $data = json_encode($data);
        $crypto = new PayonEncrypt($this->_API_APP_SECRET_KEY);
        $data = $crypto->Encrypt($data);
        $checksum = md5($this->_APP_ID . $data . $this->_API_APP_SECRET_KEY);
        $bodyPost = array(
            'app_id' => $this->_APP_ID,
            'data' => $data,
            'checksum' => $checksum,
        );
        $result = $this->call($bodyPost, "checkPayment");
        return $this->resultOrder($result);
        //return $result;
    }

    public function actionCreateorderpaynow(){
        {
            $param = $_POST;
            $param['merchant_request_id'] = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            $data = array(
                'merchant_request_id' =>  $param["merchant_request_id"],
                "merchant_id" => $this->_MC_ID,// $param["merchant_id"],
                "amount" => (int)$param["amount"],
                "description" => $param["description"],
                "url_redirect" => 'http://yii2_test.local/site/check-payment',
                "url_notify" => 'http://yii2_test.local/site/notification',
                "url_cancel" => 'http://yii2_test.local/site/cancel',
                "customer_fullname" => $param["payon_name"],
                "customer_email" => $param["payon_email"],
                "customer_mobile" => $param["payon_phone"],
            );

            // add order record to db
            $order = new Order();
            foreach ($data as $key => $value) {
                $order->$key = $value;
            }

            echo '<pre>';
            print_r("==> Param request:");
            print_r($data);
            $data = json_encode($data);
            $crypto = new PayonEncrypt($this->_API_APP_SECRET_KEY);
            $data = $crypto->Encrypt($data);
            $checksum = md5($this->_APP_ID . $data . $this->_API_APP_SECRET_KEY);
            $bodyPost = array(
                'app_id' => $this->_APP_ID,
                'data' => $data,
                'checksum' => $checksum,
            );
            $result = $this->call($bodyPost, "createOrderPaynow");

            // add payment_token to order
            $order->payment_token = $result['data']['payment_token'];
            $order->save();

            if ($result['error_code'] == "00") {
                $urlCheckout = $result['data']['url_checkout'];
                if ($urlCheckout) {
                    header("Location: ".$urlCheckout);
                    exit();
                }
            }else {
                echo $result['error_message'];
            }
        }
    }

    function Call($params, $fnc)
    {
        echo '<pre>';
        print_r("==> Body Post:");
        print_r($params);
        echo $this->_URL_API . $fnc;
        $curl = curl_init($this->_URL_API . $fnc);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_USERPWD, $this->_MC_AUTH_USER . ':' . $this->_MC_AUTH_PASS);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json')
        );
        $response = curl_exec($curl);
        $resultStatus = curl_getinfo($curl);
        if ($resultStatus['http_code'] == 200) {
            //echo $response;
            $data = json_decode($response, true);
            return $data;
        } else {
            echo 'Call Failed ' . print_r($resultStatus);
        }
    }

    /**
     * @param $result
     */
    public function resultOrder($result) {
        $data = $result['data'];
        $resultData = [
            'merchant_id' => $data['merchant_id'],
            'merchant_request_id' => $data['merchant_request_id'],
            'payment_id' => $data['payment_id'],
            'payment_token' => $data['payment_token'],
            'time_performed' => $data['time_performed'],
            'amount' => $data['amount'],
            'fee' => $data['fee'],
            'status' => $data['status'],
        ];

        $order = Order::find()->where(['payment_token' => $data['payment_token']])->one();
        $order->time_performed = $data['time_performed'];
        $order->fee = $data['fee'];
        $order->status = $data['status'];
        $order->save();
        $urlReturn = Url::base(true).'/site/order-success?merchant_request_id='.$data['merchant_request_id'];
        header("Location: ".$urlReturn);
        exit();
    }

    /**
     * @return string
     */
    public function actionOrderSuccess() {
        $request = Yii::$app->request;
        $merchantRequestId = $request->get('merchant_request_id');
        $model = Order::find()->where(['merchant_request_id' => $merchantRequestId])->one();
        $helper = new Helper();
        $statusLabel = $helper->statusHelper($model->status);
        $model->setAttribute("statusLabel",$statusLabel);
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('orderSuccess', [
            'model' => $model,
        ]);
    }

}
