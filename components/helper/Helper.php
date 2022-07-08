<?php
namespace app\components\helper;

class Helper {

    /**
     * @param $status
     * @return string
     */
    public function statusHelper($status) {
        $statusDefine = [
            '1' => 'Mới tạo',
            '2' => 'Thành công',
            '3' => 'Thất bại',
            '4' => 'Đang xử lý',
            '5' => 'Được hoàn tiền',
            '6' => 'Bị từ chối',
        ];
        return 'Thanh toán '.$statusDefine[$status];
    }

    /**
     * @param $price
     * @param $percent
     * @return mixed
     */
    public static function getPricePercent($price, $percent){
        $pricePercent = $price/100*$percent;
        $price['currentPrice'] = $price-$pricePercent;
        $price['percentPrice'] = $pricePercent;
        return $price;
    }
}
