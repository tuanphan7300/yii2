<?php

namespace app\controllers;

use app\components\helper\ConvertsUtil;
use app\models\Order;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Product;
use app\components\helper\PayonEncrypt;
use app\components\helper\helper;
use app\components\helper\PayonHelper;
use yii\helpers\Url;

class ProductController extends Controller
{

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
        $model = (new Product)->getAllProduct();
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('productList', [
            'model' => $model,
        ]);
    }

    public function actionProductDetail()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Product::getProductById($id);

        // get bank installment
        $listBankInstallment = (new PayonHelper)->GetBankInstallment();
        $listBankInstallment = $listBankInstallment['data']['Banks'];

        if ($model === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('product', [
            'model' => $model,
            'listBanks' => $listBankInstallment
        ]);
    }

    public function actionCreateOrderPayNow(){
        {
            $param = $_POST;
            $data = array(
                "merchant_request_id" => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
                "merchant_id" => (new PayonHelper)->_MC_ID,// $param["merchant_id"],
                "amount" => (int)$param["amount"],
                "description" => $param['Product']["description"],
                "url_redirect" => 'http://yii2_test.local/product/check-payment',
                "url_notify" => 'http://yii2_test.local/product/notification',
                "url_cancel" => 'http://yii2_test.local/product/cancel',
                "customer_fullname" => $param['Product']["payon_name"],
                "customer_email" => $param['Product']["payon_email"],
                "customer_mobile" => $param['Product']["payon_phone"],
            );
            $resultCreateOrder = (new PayonHelper)->CreateOrderPaynow($data);
            $data['payment_token'] = $resultCreateOrder['data']['payment_token'];
            $data['merchant_request_id'] = $resultCreateOrder['data']['merchant_request_id'];
            $data['is_installment'] = 0;
            //create new order in db
            Order::createOrder($data);
            if ($resultCreateOrder['error_code'] == "00") {
                $urlCheckout = $resultCreateOrder['data']['url_checkout'];
                if ($urlCheckout) {
                    header("Location: ".$urlCheckout);
                    exit();
                }
            }else {
                echo $resultCreateOrder['error_message'];
            }
        }
    }

    public function actionCheckPayment()
    {
        //get payment_token from response payon
        $payment_token = $_GET['payment_token'];
        //get merchant_request_id when create order from db
        $order = (new Order)->getOrderByTokenPayment($payment_token);
        $data = array(
            'merchant_request_id' => $order->merchant_request_id
        );
        $resultCheckPayment = (new PayonHelper)->checkPayment($data);
        return $this->resultOrder($resultCheckPayment);
    }

    public function actionGetFee(){
        $data = [
            'merchant_id' => (new PayonHelper)->_MC_ID,
            'amount'    => (int)$_REQUEST['amount'],
            'bank_code' => $_REQUEST['payon_bank'],
            'cycle'  => (int)$_REQUEST['payon_cycle'],
            'card_type' => strtoupper($_REQUEST['payon_card'])
        ];
        $fee = (new PayonHelper)->getFee($data);
        $resultData = $fee['data'];
        $resultData['feePayment'] = $resultData['fee'];
        $total_amount = $resultData['amount_payment'] + $resultData['fee'];
        $payment_per_month = $total_amount/$data['cycle'];
        $resultData['total_amount'] = number_format($total_amount);
        $resultData['payment_per_month'] = number_format($payment_per_month);
        $resultData['fee'] = number_format($resultData['fee']);
        echo json_encode($resultData);
    }

    public function actionCreateOrderInstallment(){
        $data = [
            'merchant_id' => (new PayonHelper)->_MC_ID,
            'merchant_request_id'    => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
            'description' => $_REQUEST['Product']['description'],
            'amount'  => (int)$_REQUEST['amount'],
            'bank_code' => $_REQUEST['payon_bank'],
            'cycle' => (int)$_REQUEST['payon_cycle'],
            'card_type' => $_REQUEST['payon_card'],
            'userfee' => 1,
            'url_redirect' => 'http://yii2_test.local/product/check-payment',
            'url_notify' => 'http://yii2_test.local/product/notification',
            'url_cancel' => 'http://yii2_test.local/product/cancel',
            'customer_fullname' => $_REQUEST['Product']['payon_name'],
            'customer_email' => $_REQUEST['Product']['payon_email'],
            'customer_mobile' => $_REQUEST['Product']['payon_phone'],
        ];
        $result = (new PayonHelper)->createOrderInstallment($data);

        $data['payment_token'] = $result['data']['payment_token'];
        $data['is_installment'] = 1;
        $data['amount'] = $_REQUEST['amount'];
        $data['fee'] = (int)$_REQUEST['fee'];
        //create new order in db
        Order::createOrder($data);
        if ($result['error_code'] == '00') {
            header('Location: '. $result['data']['url_checkout']);
            exit();
        }
        echo 'error';

    }


    public function resultOrder($result) {
        $data = $result['data'];
        $order = (new Order)->getOrderByTokenPayment($data['payment_token']);
        (new Order)->updateOrderAfterCheckPayment($order->id,$data);
        $urlReturn = Url::base(true).'/order/order-complete?merchant_request_id='.$data['merchant_request_id'];
        header("Location: ".$urlReturn);
        exit();
    }

}
