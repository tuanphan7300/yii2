<?php

use yii\db\Migration;

/**
 * Class m220706_033026_create_table_order
 */
class m220706_033054_create_table_order extends Migration
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
        echo "m220706_033026_create_table_order cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'merchant_request_id' => $this->string()->notNull(),
            'merchant_id' => $this->string()->notNull(),
            'amount' => $this->integer()->notNull(),
            'description' => $this->String()->notNull(),
            'url_redirect' => $this->String()->notNull(),
            'url_notify' => $this->String(),
            'url_cancel' => $this->String(),
            'customer_fullname' => $this->String(),
            'customer_email' => $this->String(),
            'customer_mobile' => $this->String(),
            'payment_token' => $this->String()->notNull(),
            'time_performed' => $this->integer(),
            'fee' => $this->integer(),
            'status' => $this->integer(),
            'bank_code' => $this->String(),
            'cycle' => $this->integer(),
            'card_type' => $this->String(),
            'userfee' => $this->integer(),
            'is_installment' => $this->integer(),
            'created_at' => $this->string(),
            'updated_at' => $this->string(),
        ]);
    }

    public function down()
    {
        echo "m220706_033026_create_table_order cannot be reverted.\n";

        return false;
    }

}
