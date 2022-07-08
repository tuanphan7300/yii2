<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Product $model */
/** @var app\models\Order $order */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$this->title = 'Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
<!--    <form method="post" action="create-order-installment" id="payon_form" novalidate="novalidate">-->
    <?php $form = ActiveForm::begin(['id' => 'payon_form','action' => '/product/create-order-installment']); ?>
        <input id="usefee" type="hidden" name="usefee" value="1">
        <input id="feePayment" type="hidden" name="fee" value="">
        <input id="totalPayment" type="hidden" name="totalPayment" value="">
        <div class="row">
            <div class="col-lg-5">
                <div>
                    <?php echo Html::img('https://126.cdn.vccloud.vn/uploads/2022/03/13_pro_max_alpine_green-300x300.png') ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div>
                    <p style="font-weight: bold"> <?= $model->name ?></p>
                    <span>Giá bán: <strong><?= number_format($model->price) ?> VND</strong></span>
                    <input id="amount" name="amount" type="hidden" value="<?= $model->price ?>">
                </div>
                <div id="payment" class="woocommerce-checkout-payment">
                        <ul class="wc_payment_methods payment_methods methods">
                            <li class="wc_payment_method payment_method_payon">
                                <input id="payment_method_payon" type="radio" class="input-radio" name="payment_method" value="payon" checked="checked" data-order_button_text="Trả góp ngay">
                                <label for="payment_method_payon">
                                    Trả góp qua PayOn 	</label>
                            </li>
                            <li class="wc_payment_method payment_method_payon_paynow">
                                <input id="payment_method_payon_paynow" type="radio" class="input-radio" name="payment_method" value="payon_paynow"  data-order_button_text="Thanh toán ngay">
                                <label for="payment_method_payon_paynow">
                                    Thanh toán online ATM, Visa, Qr Code... 	</label>
                            </li>
                        </ul>
                        <div class="payment_box payment_method_payon_paynow" style="display:none;">
                            <p>Thanh toán online qua PayOn. Bạn sẽ được chuyển tới payon.vn để tiến hành thanh toán. Bảo mật và an toàn</p>
                        </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="devvn_tragop_main payon" id="devvn_tragop_main">
            <div class="devvn_installment_payon">

                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                    <div class="devvn_payon_box">
                        <div class="payon_label devvn_tragop_title">Bước 1: Chọn ngân hàng trả góp</div><div class="payon_listbank_mess"></div><div class="payon_listbank">
                            <?php foreach($listBanks as $bank): ?>
                            <label class="devvn_bank_click" data-code="<?= $bank['code'] ?>" data-card='<?= json_encode($bank['installment_card_type']) ?>' data-name="<?= $bank['full_name'] ?>" title="<?= $bank['full_name'] ?>" data-cycle='<?= json_encode($bank['cycle']) ?>'>
                                <input value="<?= $bank['code'] ?>" name="payon_bank" type="radio">
                                <span><img data-lazyloaded="1" src="<?= 'https://payment.vimo.vn/images/bank/'.$bank['code'].'.png' ?>" data-src="<?= $bank['logo'] ?>" alt="<?= $bank['full_name'] ?>" data-ll-status="loaded" class="entered litespeed-loaded"></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="devvn_payon_box payon_card_box" style="display: none;">
                        <div class="devvn_tragop_title">Bước 2: Chọn loại thẻ</div>
                        <div class="payon_card_mess"></div>
                        <div class="payon_card payon_cardtype">
                            <label class="devvn_card_click" data-code="visa" title="visa">
                                <input value="visa" name="payon_card" type="radio">
                                <span><img src="https://126.vn/gwzv/plugins/devvn-tragop-payon/assets/images/bank/visa.png" alt="visa"></span>
                            </label>
                            <label class="devvn_card_click" data-code="mastercard" title="mastercard">
                                <input value="mastercard" name="payon_card" type="radio">
                                <span><img src="https://126.vn/gwzv/plugins/devvn-tragop-payon/assets/images/bank/mastercard.png" alt="mastercard"></span>
                            </label>
                            <label class="devvn_card_click" data-code="jcb" title="jcb">
                                <input value="jcb" name="payon_card" type="radio">
                                <span><img src="https://126.vn/gwzv/plugins/devvn-tragop-payon/assets/images/bank/jcb.png" alt="jcb"></span>
                            </label>
                        </div>
                    </div>

                    <div class="devvn_tragop_box payon_cycle_box" style="display: none">
                        <div class="devvn_tragop_col">
                            <label for="payon_prepaid" class="devvn_tragop_title">Bước 3: chọn kỳ trả góp</label>
                            <span class="radio_mess"></span>
                            <input type="hidden" name="cycle" value="">
                            <div class="list_radio_style payon_cycle_wrap">
                                <label class="payon_prepaid_cycle" data-month-cycle="3">
                                    <input type="radio" name="payon_cycle" class="payon_cycle_3" value="3">
                                    <span><strong>3</strong> Tháng</span>
                                </label>
                                <label class="payon_prepaid_cycle" data-month-cycle="6">
                                    <input type="radio" name="payon_cycle" class="payon_cycle_6" value="6">
                                    <span><strong>6</strong> Tháng</span>
                                </label>
                                <label class="payon_prepaid_cycle" data-month-cycle="9">
                                    <input type="radio" name="payon_cycle" class="payon_cycle_9" value="9">
                                    <span><strong>9</strong> Tháng</span>
                                </label>
                                <label class="payon_prepaid_cycle" data-month-cycle="12">
                                    <input type="radio" name="payon_cycle" class="payon_cycle_12" value="12">
                                    <span><strong>12</strong> Tháng</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="devvn_tragop_box total_payon_wrap" style="display: none">
                        <div class="devvn_tragop_col">
                            <ul class="payon_table_results">
                                <li>
                                    <strong>Tổng tiền thanh toán</strong>
                                    <span class="total_pay"></span>
                                </li>
                                <li>
                                    <strong>Góp mỗi tháng</strong>
                                    <span class="total_month"></span>
                                </li>
                                <li>
                                    <strong>Chênh lệch so với giá ban đầu</strong>
                                    <span class="chenhlech_payon"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
        <div class="devvn_tragop_main payon" id="payon_customer_info">
                <div class="payon_infor_customer" style="display: block">
                    <div class="devvn_tragop_box">
                        <label class="devvn_tragop_title">Thông tin người mua</label>
                        <div class="devvn_tragop_col1">
                            <?= $form->field($model, 'payon_name') ?>
                        </div>
                        <div class="devvn_tragop_col2">
                            <?= $form->field($model, 'payon_phone') ?>
                        </div>
                    </div>
                    <div class="devvn_tragop_box">
                        <div class="devvn_tragop_col1">
                            <?= $form->field($model, 'payon_email') ?>
                        </div>
                        <div class="devvn_tragop_col2">
                            <?= $form->field($model, 'payon_address') ?>
                        </div>
                    </div>
                    <div class="devvn_tragop_box">
                        <div class="devvn_tragop_col1">
                            <?= $form->field($model, 'description') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="payon-payment-button">
            <input type="hidden" id="payon_nonce" name="payon_nonce" value="2a72c44631"><input type="hidden" name="_wp_http_referer" value="/tra-gop-payon-vn/14953-iphone-13-pro-max-128gb-moi-chinh-hang-vn-a/?type=payon">                                <input type="hidden" value="14953" name="prod_id">
            <?= Html::submitButton('Trả góp ngay', ['class' => 'btn btn-primary payon_nonce_button', 'value'=>'submit', 'name'=>'submit', 'disabled' => 'true']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<!--    </form>-->
</div>
