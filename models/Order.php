<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


class Order extends ActiveRecord
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param $tokenPayment
     * @return array|ActiveRecord|null
     */
    public function getOrderByTokenPayment($tokenPayment){
        $order = Order::find()->where(['payment_token' => $tokenPayment])->one();
        return $order;
    }

    /**
     * @param $id
     * @param $data
     */
    public function updateOrderAfterCheckPayment($id,$data){
        $order = Order::findOne($id);
        $order->time_performed = $data['time_performed'];
        $order->status = $data['status'];
        $order->save();
    }

    /**
     * @param $data
     */
    public static function createOrder($data){
        $order = new Order;
        foreach ($data as $key => $value) {
            $order->$key = $value;
        }
        $order->save(false);
    }

}