<?php

namespace app\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{

    public $payon_name;
    public $payon_phone;
    public $payon_address;
    public $payon_email;
    public $description;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['payon_name', 'payon_phone', 'payon_address', 'payon_email','description'], 'required'],
            // email has to be a valid email address
            ['payon_email', 'email']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'payon_name' => 'Họ và tên',
            'payon_phone' => 'Số điện thoại',
            'payon_address' => 'Địa chỉ',
            'payon_email' => 'Email',
            'description' => 'Ghi chú',
        ];
    }


    /**
     * @return array|ActiveRecord[]
     */
    public function getAllProduct(){
        return Product::find()->all();
    }

    /**
     * @param $id
     * @return Product|null
     */
    public static function getProductById($id){
        return Product::findOne($id);
    }
}