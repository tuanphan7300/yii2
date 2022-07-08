<?php

use yii\db\Migration;

/**
 * Class m220706_033053_create_table_product
 */
class m220706_033055_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220706_033053_create_table_product cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->text(),
            'image' => $this->text()
        ]);

        $this->insert('product', [
            'name' => 'iPhone 14 Pro Max Quốc tế 1TB Mới – Chính hãng',
            'price' => '50000000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2022/06/iPhone14Pro-300x300.png'
        ]);

        $this->insert('product', [
            'name' => 'iPhone 14 Pro Max Quốc tế 512G Mới – Chính hãng',
            'price' => '40000000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2022/06/iPhone14Pro-300x300.png'
        ]);
        $this->insert('product', [
            'name' => 'iPhone 13 Pro Max Quốc tế 256GB Cũ – Nguyên bản',
            'price' => '27990000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2022/03/13_pro_max_alpine_green-300x300.png'
        ]);
        $this->insert('product', [
            'name' => 'iPhone 13 Pro Max 128GB Quốc Tế – Siêu Lướt Giá Tốt',
            'price' => '26490000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2021/09/iphone13promax126vn-300x300.jpg'
        ]);
        $this->insert('product', [
            'name' => 'iPhone 13 Pro Max 256GB – Mới – Chính Hãng VN/A',
            'price' => '30790000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2021/09/iphone13promax126vn-300x300.jpg'
        ]);
        $this->insert('product', [
            'name' => 'iPhone Xs Max Quốc tế 64GB – Mới – Chính hãng',
            'price' => '12999000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2021/06/apple-iphone-xs-max-gold-300x300.png'
        ]);
        $this->insert('product', [
            'name' => 'iPhone 13 Pro 128GB – Mới – Chính Hãng VN/A',
            'price' => '25490000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2021/09/iphone-13-pro-black-300x300.jpeg'
        ]);
        $this->insert('product', [
            'name' => 'iPhone 13 Pro Max 128GB – Mới – Chính Hãng VN/A',
            'price' => '26990000',
            'image' => 'https://126.cdn.vccloud.vn/uploads/2022/03/13_pro_max_alpine_green-300x300.png'
        ]);
    }

    public function down()
    {
        echo "m220706_033053_create_table_product cannot be reverted.\n";

        return false;
    }

}
