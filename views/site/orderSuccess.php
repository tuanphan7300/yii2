<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Order $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$this->title = 'Order Success';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="site-error">
        <div class="alert alert-success">
            <?= $model->status ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <p>Chi tiết đơn hàng</p>
        </div>
    </div>
</div>
