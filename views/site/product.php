<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Product $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$this->title = 'Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <form method="post" action="createorderpaynow" id="payon_form" novalidate="novalidate">
    <div class="row">
        <div class="col-lg-5">
            <div>
                <?php echo Html::img('https://126.cdn.vccloud.vn/uploads/2022/03/13_pro_max_alpine_green-300x300.png') ?>
            </div>
        </div>
        <div class="col-lg-5">
            <div>
                <p style="font-weight: bold"> <?= $model->name ?></p>
                <span>Giá bán: <strong><?= Yii::$app->formatter->asCurrency($model->price) ?></strong></span>
                <input name="amount" type="hidden" value="<?= $model->price ?>">
            </div>
<!--            <div class="button-payment">-->
<!--                <button type="button" class="btn btn-primary btn-payment-now">Thanh toán ngay</button>-->
<!--                <button type="button" class="btn btn-primary btn-installment">Trả Góp</button>-->
<!--            </div>-->
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
                <!--                <div class="devvn_tragop_box">-->
<!--                    <div class="devvn_tragop_col">-->
<!--                        <label for="payon_prepaid" class="devvn_tragop_title">Bước 1: Số tiền trả trước</label>-->
<!--                        <span class="radio_mess"></span>-->
<!--                        <div class="list_radio_style">-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_0" value="0" checked="checked" data-price="26990000" data-pricepay="0">-->
<!--                                <span><strong>Không <br>trả trước</strong></span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_10" value="10" data-price="24291000" data-pricepay="2699000">-->
<!--                                <span><strong>Trả trước 10%</strong><span class="woocommerce-Price-amount amount"><bdi>2.699.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_20" value="20" data-price="21592000" data-pricepay="5398000">-->
<!--                                <span><strong>Trả trước 20%</strong><span class="woocommerce-Price-amount amount"><bdi>5.398.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_30" value="30" data-price="18893000" data-pricepay="8097000">-->
<!--                                <span><strong>Trả trước 30%</strong><span class="woocommerce-Price-amount amount"><bdi>8.097.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_40" value="40" data-price="16194000" data-pricepay="10796000">-->
<!--                                <span><strong>Trả trước 40%</strong><span class="woocommerce-Price-amount amount"><bdi>10.796.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_50" value="50" data-price="13495000" data-pricepay="13495000">-->
<!--                                <span><strong>Trả trước 50%</strong><span class="woocommerce-Price-amount amount"><bdi>13.495.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_60" value="60" data-price="10796000" data-pricepay="16194000">-->
<!--                                <span><strong>Trả trước 60%</strong><span class="woocommerce-Price-amount amount"><bdi>16.194.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_prepaid" class="payon_prepaid_70" value="70" data-price="8097000" data-pricepay="18893000">-->
<!--                                <span><strong>Trả trước 70%</strong><span class="woocommerce-Price-amount amount"><bdi>18.893.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>-->
<!--                            </label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="devvn_payon_box">-->
<!--                    <div class="payon_label devvn_tragop_title">Bước 2: Chọn ngân hàng trả góp</div><div class="payon_listbank_mess"></div><div class="payon_listbank">                                    <label class="devvn_bank_click" data-code="ACB" data-card="" data-name="NH TMCP Á Châu" title="NH TMCP Á Châu">-->
<!--                            <input value="ACB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/ACB.png" data-src="https://payment.vimo.vn/images/bank/ACB.png" alt="NH TMCP Á Châu" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/ACB.png" alt="NH TMCP Á Châu"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="BIDV" data-card="" data-name="NH Đầu tư và Phát triển Việt Nam" title="NH Đầu tư và Phát triển Việt Nam">-->
<!--                            <input value="BIDV" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/BIDV.png" data-src="https://payment.vimo.vn/images/bank/BIDV.png" alt="NH Đầu tư và Phát triển Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/BIDV.png" alt="NH Đầu tư và Phát triển Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="CTB" data-card="" data-name="NH Citibank Việt Nam" title="NH Citibank Việt Nam">-->
<!--                            <input value="CTB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/CTB.png" data-src="https://payment.vimo.vn/images/bank/CTB.png" alt="NH Citibank Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/CTB.png" alt="NH Citibank Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="EXB" data-card="" data-name="NH TMCP Xuất Nhập Khẩu" title="NH TMCP Xuất Nhập Khẩu">-->
<!--                            <input value="EXB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/EXB.png" data-src="https://payment.vimo.vn/images/bank/EXB.png" alt="NH TMCP Xuất Nhập Khẩu" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/EXB.png" alt="NH TMCP Xuất Nhập Khẩu"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="HDB" data-card="" data-name="NH TMCP Phát Triển TPHCM" title="NH TMCP Phát Triển TPHCM">-->
<!--                            <input value="HDB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/HDB.png" data-src="https://payment.vimo.vn/images/bank/HDB.png" alt="NH TMCP Phát Triển TPHCM" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/HDB.png" alt="NH TMCP Phát Triển TPHCM"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="HOMEC" data-card="" data-name="CTy Tài Chính TNHH MTV Home Credit Việt Nam" title="CTy Tài Chính TNHH MTV Home Credit Việt Nam">-->
<!--                            <input value="HOMEC" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/HOMEC.png" data-src="https://payment.vimo.vn/images/bank/HOMEC.png" alt="CTy Tài Chính TNHH MTV Home Credit Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/HOMEC.png" alt="CTy Tài Chính TNHH MTV Home Credit Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="HSBC" data-card="" data-name="NH TNHH MTV HSBC" title="NH TNHH MTV HSBC">-->
<!--                            <input value="HSBC" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/HSBC.png" data-src="https://payment.vimo.vn/images/bank/HSBC.png" alt="NH TNHH MTV HSBC" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/HSBC.png" alt="NH TNHH MTV HSBC"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="ICB" data-card="" data-name="NH TMCP Công Thương" title="NH TMCP Công Thương">-->
<!--                            <input value="ICB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/ICB.png" data-src="https://payment.vimo.vn/images/bank/ICB.png" alt="NH TMCP Công Thương" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/ICB.png" alt="NH TMCP Công Thương"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="KLB" data-card="" data-name="NH TMCP Kiên Long" title="NH TMCP Kiên Long">-->
<!--                            <input value="KLB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/KLB.png" data-src="https://payment.vimo.vn/images/bank/KLB.png" alt="NH TMCP Kiên Long" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/KLB.png" alt="NH TMCP Kiên Long"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="LOTTE" data-card="" data-name="CTy Tài chính Lotte Việt Nam" title="CTy Tài chính Lotte Việt Nam">-->
<!--                            <input value="LOTTE" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/LOTTE.png" data-src="https://payment.vimo.vn/images/bank/LOTTE.png" alt="CTy Tài chính Lotte Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/LOTTE.png" alt="CTy Tài chính Lotte Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="LVB" data-card="" data-name="NH Bưu điện Liên Việt" title="NH Bưu điện Liên Việt">-->
<!--                            <input value="LVB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/LVB.png" data-src="https://payment.vimo.vn/images/bank/LVB.png" alt="NH Bưu điện Liên Việt" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/LVB.png" alt="NH Bưu điện Liên Việt"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="MB" data-card="" data-name="NH TMCP Quân Đội" title="NH TMCP Quân Đội">-->
<!--                            <input value="MB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/MB.png" data-src="https://payment.vimo.vn/images/bank/MB.png" alt="NH TMCP Quân Đội" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/MB.png" alt="NH TMCP Quân Đội"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="MCREDIT" data-card="" data-name="CÔNG TY TÀI CHÍNH TNHH MB SHINSEI" title="CÔNG TY TÀI CHÍNH TNHH MB SHINSEI">-->
<!--                            <input value="MCREDIT" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/MCREDIT.png" data-src="https://payment.vimo.vn/images/bank/MCREDIT.png" alt="CÔNG TY TÀI CHÍNH TNHH MB SHINSEI" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/MCREDIT.png" alt="CÔNG TY TÀI CHÍNH TNHH MB SHINSEI"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="MSB" data-card="" data-name="NH TMCP Hàng Hải" title="NH TMCP Hàng Hải">-->
<!--                            <input value="MSB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/MSB.png" data-src="https://payment.vimo.vn/images/bank/MSB.png" alt="NH TMCP Hàng Hải" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/MSB.png" alt="NH TMCP Hàng Hải"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="OCB" data-card="" data-name="NH TMCP Phương Đông Việt Nam" title="NH TMCP Phương Đông Việt Nam">-->
<!--                            <input value="OCB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/OCB.png" data-src="https://payment.vimo.vn/images/bank/OCB.png" alt="NH TMCP Phương Đông Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/OCB.png" alt="NH TMCP Phương Đông Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="PVB" data-card="" data-name="NH TMCP Đại Chúng Việt Nam" title="NH TMCP Đại Chúng Việt Nam">-->
<!--                            <input value="PVB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/PVB.png" data-src="https://payment.vimo.vn/images/bank/PVB.png" alt="NH TMCP Đại Chúng Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/PVB.png" alt="NH TMCP Đại Chúng Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="SCB" data-card="" data-name="NH TMCP Sài Gòn" title="NH TMCP Sài Gòn">-->
<!--                            <input value="SCB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/SCB.png" data-src="https://payment.vimo.vn/images/bank/SCB.png" alt="NH TMCP Sài Gòn" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/SCB.png" alt="NH TMCP Sài Gòn"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="SCBL" data-card="" data-name="NH TNHH MTV Standard Chartered (Việt Nam) " title="NH TNHH MTV Standard Chartered (Việt Nam) ">-->
<!--                            <input value="SCBL" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/SCBL.png" data-src="https://payment.vimo.vn/images/bank/SCBL.png" alt="NH TNHH MTV Standard Chartered (Việt Nam) " data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/SCBL.png" alt="NH TNHH MTV Standard Chartered (Việt Nam) "></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="SEA" data-card="" data-name="NH TMCP Đông Nam Á" title="NH TMCP Đông Nam Á">-->
<!--                            <input value="SEA" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/SEA.png" data-src="https://payment.vimo.vn/images/bank/SEA.png" alt="NH TMCP Đông Nam Á" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/SEA.png" alt="NH TMCP Đông Nam Á"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="SHB" data-card="" data-name="NH TMCP Sài Gòn - Hà Nội" title="NH TMCP Sài Gòn - Hà Nội">-->
<!--                            <input value="SHB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/SHB.png" data-src="https://payment.vimo.vn/images/bank/SHB.png" alt="NH TMCP Sài Gòn - Hà Nội" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/SHB.png" alt="NH TMCP Sài Gòn - Hà Nội"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="SHBKV" data-card="" data-name="NH TNHH MTV Shinhan Việt Nam" title="NH TNHH MTV Shinhan Việt Nam">-->
<!--                            <input value="SHBKV" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/SHBKV.png" data-src="https://payment.vimo.vn/images/bank/SHBKV.png" alt="NH TNHH MTV Shinhan Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/SHBKV.png" alt="NH TNHH MTV Shinhan Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="STB" data-card="" data-name="NH TMCP Sài Gòn Thương Tín" title="NH TMCP Sài Gòn Thương Tín">-->
<!--                            <input value="STB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/STB.png" data-src="https://payment.vimo.vn/images/bank/STB.png" alt="NH TMCP Sài Gòn Thương Tín" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/STB.png" alt="NH TMCP Sài Gòn Thương Tín"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="TCB" data-card="" data-name="NH TMCP Kỹ Thương" title="NH TMCP Kỹ Thương">-->
<!--                            <input value="TCB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/TCB.png" data-src="https://payment.vimo.vn/images/bank/TCB.png" alt="NH TMCP Kỹ Thương" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/TCB.png" alt="NH TMCP Kỹ Thương"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="TPB" data-card="" data-name="NH TMCP Tiên Phong" title="NH TMCP Tiên Phong">-->
<!--                            <input value="TPB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/TPB.png" data-src="https://payment.vimo.vn/images/bank/TPB.png" alt="NH TMCP Tiên Phong" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/TPB.png" alt="NH TMCP Tiên Phong"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="VCB" data-card="" data-name="NH TMCP Ngoại Thương Việt Nam" title="NH TMCP Ngoại Thương Việt Nam">-->
<!--                            <input value="VCB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/VCB.png" data-src="https://payment.vimo.vn/images/bank/VCB.png" alt="NH TMCP Ngoại Thương Việt Nam" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/VCB.png" alt="NH TMCP Ngoại Thương Việt Nam"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="VCCB" data-card="" data-name="NH TMCP Bản Việt" title="NH TMCP Bản Việt">-->
<!--                            <input value="VCCB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/VCCB.png" data-src="https://payment.vimo.vn/images/bank/VCCB.png" alt="NH TMCP Bản Việt" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/VCCB.png" alt="NH TMCP Bản Việt"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="VIB" data-card="" data-name="NH TMCP Quốc tế" title="NH TMCP Quốc tế">-->
<!--                            <input value="VIB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/VIB.png" data-src="https://payment.vimo.vn/images/bank/VIB.png" alt="NH TMCP Quốc tế" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/VIB.png" alt="NH TMCP Quốc tế"></noscript></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_bank_click" data-code="VPB" data-card="" data-name="NH TMCP Việt Nam Thịnh Vượng" title="NH TMCP Việt Nam Thịnh Vượng">-->
<!--                            <input value="VPB" name="payon_bank" type="radio">-->
<!--                            <span><img data-lazyloaded="1" src="https://payment.vimo.vn/images/bank/VPB.png" data-src="https://payment.vimo.vn/images/bank/VPB.png" alt="NH TMCP Việt Nam Thịnh Vượng" data-ll-status="loaded" class="entered litespeed-loaded"><noscript><img src="https://payment.vimo.vn/images/bank/VPB.png" alt="NH TMCP Việt Nam Thịnh Vượng"></noscript></span>-->
<!--                        </label>-->
<!--                    </div>                        </div>-->
<!---->
<!--                <div class="devvn_payon_box payon_card_box" style="display: block;">-->
<!--                    <div class="devvn_tragop_title">Bước 3: Chọn loại thẻ</div>-->
<!--                    <div class="payon_card_mess"></div>-->
<!--                    <div class="payon_card payon_cardtype"><label class="devvn_card_click" data-code="visa" title="visa">-->
<!--                            <input value="visa" name="payon_card" type="radio">-->
<!--                            <span><img src="https://126.vn/gwzv/plugins/devvn-tragop-payon/assets/images/bank/visa.png" alt="visa"></span>-->
<!--                        </label>-->
<!--                        <label class="devvn_card_click" data-code="mastercard" title="mastercard">-->
<!--                            <input value="mastercard" name="payon_card" type="radio">-->
<!--                            <span><img src="https://126.vn/gwzv/plugins/devvn-tragop-payon/assets/images/bank/mastercard.png" alt="mastercard"></span>-->
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="devvn_tragop_box payon_cycle_box" style="">-->
<!--                    <div class="devvn_tragop_col">-->
<!--                        <label for="payon_prepaid" class="devvn_tragop_title">Bước 4: chọn kỳ trả góp</label>-->
<!--                        <span class="radio_mess"></span>-->
<!--                        <div class="list_radio_style payon_cycle_wrap"><label>-->
<!--                                <input type="radio" name="payon_cycle" class="payon_cycle_3" value="3">-->
<!--                                <span><strong>3</strong> Tháng</span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_cycle" class="payon_cycle_6" value="6">-->
<!--                                <span><strong>6</strong> Tháng</span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_cycle" class="payon_cycle_9" value="9">-->
<!--                                <span><strong>9</strong> Tháng</span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="radio" name="payon_cycle" class="payon_cycle_12" value="12">-->
<!--                                <span><strong>12</strong> Tháng</span>-->
<!--                            </label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="devvn_tragop_box total_payon_wrap" style="display: none">-->
<!--                    <div class="devvn_tragop_col">-->
<!--                        <ul class="payon_table_results">-->
<!--                            <li>-->
<!--                                <strong>Thanh toán khi nhận hàng</strong>-->
<!--                                <span class="total_pay"></span>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <strong>Góp mỗi tháng</strong>-->
<!--                                <span class="total_month"></span>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <strong>Tổng tiền trả góp</strong>-->
<!--                                <span class="total_payon"></span>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <strong>Chênh lệch so với giá ban đầu</strong>-->
<!--                                <span class="chenhlech_payon"></span>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="payon_infor_customer" style="display: block">
                    <div class="devvn_tragop_box">
                        <label class="devvn_tragop_title">Thông tin người mua</label>
                        <div class="devvn_tragop_col1">
                            <input type="text" name="payon_name" placeholder="Họ và tên" value="" required="">
                        </div>
                        <div class="devvn_tragop_col2">
                            <input type="text" name="payon_phone" placeholder="Số điện thoại" value="" required="">
                        </div>
                    </div>
                    <div class="devvn_tragop_box">
                        <div class="devvn_tragop_col1">
                            <input type="text" name="payon_email" placeholder="Email của bạn" value="">
                        </div>
                        <div class="devvn_tragop_col2">
                            <input type="text" name="payon_address" placeholder="Địa chỉ của bạn" value="">
                        </div>
                    </div>
                    <div class="devvn_tragop_box">
                        <div class="devvn_tragop_col1">
                            <input type="text" name="description" placeholder="Ghi chú" value="">
                        </div>
                    </div>
                </div>
                <div class="payon-payment-button">
                    <input type="hidden" id="payon_nonce" name="payon_nonce" value="2a72c44631"><input type="hidden" name="_wp_http_referer" value="/tra-gop-payon-vn/14953-iphone-13-pro-max-128gb-moi-chinh-hang-vn-a/?type=payon">                                <input type="hidden" value="14953" name="prod_id">
                    <?= Html::submitButton('Trả góp ngay', ['class' => 'btn btn-primary payon_nonce_button', 'value'=>'submit', 'name'=>'submit']) ?>
                </div>
        </div>
    </div>
    </form>
</div>
