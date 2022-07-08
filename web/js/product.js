var payon_bank;
var payon_card;
var payon_cycle;
var payment_method_payon_paynow;

$( document ).ready(function() {

    $('#payon_form input').on('change', function() {
        payon_bank = $('input[name=payon_bank]:checked', '#payon_form').val()
        payon_card = $('input[name=payon_card]:checked', '#payon_form').val()
        payon_cycle = $('input[name=payon_cycle]:checked', '#payon_form').val()
        checkData();
    });

    $('#payment input').on('change', function() {
        payment_method_payon_paynow = $('input[name=payment_method]:checked', '#payon_form').val()
        if (payment_method_payon_paynow == 'payon_paynow') {
            $('#payon_form').attr('action', '/product/create-order-pay-now');
            $('#devvn_tragop_main').css('display','none');
            $('.payon_nonce_button').text("Thanh toán ngay");
        }else{
            $('#payon_form').attr('action', '/product/create-order-installment');
            $('#devvn_tragop_main').css('display','block');
            $('.payment_box').css("display", "none")
            $('.devvn_payon_box').css("display", "block")
            $('.b1').css("display", "block")
            $('.payon_nonce_button').text("Trả góp ngay");
        }
    });

    $('.devvn_bank_click').on('click', function () {
        var _this = this;
        var data_card = $(_this).attr('data-card');
        data_card = JSON.parse(data_card);
        $('.payon_card_box').css("display", "block");
        $('.devvn_card_click').each(function() {
            var data_card_box = $(this).attr('data-code');
            if($.inArray(data_card_box, data_card) !== -1) {
                $(this).removeAttr('hidden');
            }else{
                $(this).prop('hidden', true);
            }
        });

        checkDataCycle(_this);
    })
});

function checkData() {
    if (payon_bank && payon_card && payon_cycle) {
        var amount = parseInt($('#amount').val());
        $.ajax({
            url: 'http://yii2_test.local/product/get-fee',
            type: 'POST',
            data: {
                payon_bank: payon_bank,
                payon_card: payon_card,
                payon_cycle: payon_cycle,
                amount: amount
            },
            dataType: 'JSON',
            success: function (response) {
                console.log(response)
                var totalPayment = parseInt(amount) + parseInt(response.fee);
                $('#totalPayment').val(totalPayment);
                $('#feePayment').val(response.feePayment);
                $('.total_pay').text(response.total_amount);
                $('.total_month').text(response.payment_per_month);
                $('.chenhlech_payon').text(response.fee);
                $('.total_payon_wrap').css('display','block');
            },
        });
        $('.payon_nonce_button').removeAttr('disabled');
    }else
        $('payon_nonce_button').prop('disabled', true);
}

function checkDataCycle(_this){
    $('.payon_cycle_box').css("display", "block");
    var data_cycle = $(_this).attr('data-cycle');
    data_cycle = JSON.parse(data_cycle);
    $('.payon_prepaid_cycle').each(function() {
        var data_month_cycle = $(this).attr('data-month-cycle');
        if($.inArray(data_month_cycle, data_cycle) !== -1) {
            $(this).removeAttr('hidden');
        }else{
            $(this).prop('hidden', true);
        }
    });
}

