<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Order $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$this->title = 'Order Complete';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="site-error">
        <div class="alert alert-success">
            <?php echo $statusLabel; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <h3>Chi tiết đơn hàng</h3>
            <p>Cảm ơn. Đơn hàng của bạn đã <?php echo $statusLabel; ?></p>
            <p>Ngày: <?= $model->updated_at ?></p>
            <p>Email: <?= $model->customer_email ?></p>
            <p>Tổng Tiền: <?= $model->amount  ?></p>
            <p>Phương thức thanh toán: </p>

        </div>
    </div>
</div>
