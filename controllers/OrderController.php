<?php

namespace app\controllers;

use app\models\Order;
use Yii;
use yii\base\BaseObject;
use yii\web\Controller;
use app\models\Product;
use app\components\helper\helper;

class OrderController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionOrderComplete()
    {
        $request = Yii::$app->request;
        $merchantRequestId = $request->get('merchant_request_id');
        $model = Order::find()->where(['merchant_request_id' => $merchantRequestId])->one();
        $statusLabel = (new Helper)->statusHelper($model->status);
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('orderComplete', [
            'model' => $model,
            'statusLabel' => $statusLabel
        ]);
    }


}
