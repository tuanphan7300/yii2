<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Product $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;
use yii\helpers\Url;
use app\components\helper\ConvertsUtil;

$this->title = 'ProductList';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="row">
            <?php foreach ($model as $row): ?>
                <div class="col-md-2">
                    <a href="<?= Url::to(['product-detail', 'id' => $row->id]); ?>"><img src="<?= $row->image ?>" width="100%" height="auto"  class="attachment-shop_catalog size-shop_catalog wp-post-image lazy" alt="<?= $row->name ?>"/></a>
                    <div class="product-short-content">
                        <a href="<?= Url::to(['product-detail', 'id' => $row->id]); ?>"><?= $row->name ?></a>
                        <p><?= number_format($row->price) ?> VND</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
