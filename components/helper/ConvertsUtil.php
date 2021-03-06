<?php

namespace app\components\helper;

//use common\models\enum\DefaultEnum;
use Yii;

class ConvertsUtil
{
    static function convert84Tel($mobilenumber)
    {
        $mobilenumber = self::setMobileNumber($mobilenumber);
        return '0' . $mobilenumber;
    }

    public static function setMobileNumber($phone)
    {
        $oneNumberFirst = substr($phone, 0, 1);
        $twoNumberFirst = substr($phone, 0, 2);
        $length = strlen($phone);
        if (self::checkZozo($oneNumberFirst)) {
            $phone = substr($phone, 1, ($length - 1));
        } elseif (self::check84($twoNumberFirst)) {
            $phone = substr($phone, 2, ($length - 2));
        }

        return $phone;
    }

    /*
     * Kiem tra co phai la so 0 khong
     */

    public static function checkZozo($number)
    {
        if ($number == '0' or $number === 0) {
            return true;
        }
        return false;
    }

    /*
     * Kiem tra co phai la so 84 khong
     */

    public static function check84($number)
    {
        if ($number == '84' or $number == 84) {
            return true;
        }
        return false;
    }

    public static function ImgHeaderFormat($data)
    {
        $img = preg_replace('#^data:image/[^;]+;base64,#', '', $data);

        return $img;
    }

    /**
     * Format number to string
     * @param string $mobile
     * @return string
     */
    public static function FormatMobile($phoneNumber)
    {
        if (strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 9);
            $areaCode = substr($phoneNumber, -9, 3);
            $nextThree = substr($phoneNumber, -6, 3);
            $lastFour = substr($phoneNumber, -3, 4);

            $phoneNumber = $countryCode . ' ' . $areaCode . ' ' . $nextThree . ' ' . $lastFour;
        } else if (strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = $areaCode . ' ' . $nextThree . ' ' . $lastFour;
        } else if (strlen($phoneNumber) == 8) {
            $nextThree = substr($phoneNumber, 0, 4);
            $lastFour = substr($phoneNumber, 4, 4);

            $phoneNumber = $nextThree . ' ' . $lastFour;
        } else if (strlen($phoneNumber) < 10) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);

            $phoneNumber = $nextThree . ' ' . $lastFour;
        }
        return $phoneNumber;
    }

    public static function FormatHotline($phoneNumber)
    {

        $nextThree = substr($phoneNumber, 0, 4);
        $lastFour = substr($phoneNumber, 4, 4);
        $phoneNumber = $nextThree . '.' . $lastFour;
        return $phoneNumber;
    }

    /**
     * Format number to string
     * @param string $card
     * @return string
     */
    public static function FormatCard($card)
    {
        if (empty($card)) return '';

        $array = str_split($card, 4);

        $cardFormat = '';
        foreach ($array as $value) {
            $cardFormat = $cardFormat ? $cardFormat . ' ' . $value : $value;
        }

        return $cardFormat;
    }
    /**
     * mask identity card, just show last 3 character
     * @param string $card
     * @return string
     */
    public static function maskIdentityCard($card)
    {
        $cc_length = strlen($card);
        for ($i = 0; $i < $cc_length - 3; $i++) {
            $card[$i] = "*";
        }
        return $card;
    }

    /**
     * Format number to string
     * @param string $number
     * @param integer $decimals (0 or 2)
     * @param boolean $type
     * @return string
     */
    public static function NumberFormat($number = null, $decimals = null, $type = true)
    {
        //check number is integer or float to get decimal point of number
        if ($decimals === null) {
            $decimals = is_float($number) ? 2 : 0;
        }
        if ($type) {
            return number_format($number, $decimals, ',', '.'); // ex: 100.000,00
        }
        return number_format($number, $decimals, '.', ','); // ex: 100,000.00
    }

    /**
     * Generate authorization
     * @param string $username
     * @param string $password
     * @return string Authorization
     */
    public static function GenerateAuthorization($username, $password)
    {
        return 'Basic ' . base64_encode($username . ":" . $password);
    }

//    public static function ConvertIntToDate($timestamp, $isDate = false)
//    {
//        if (empty($timestamp)) {
//            return '';
//        }
//        $date = new \DateTime();
//        $date->setTimezone(new \DateTimeZone(Yii::$app->params['gmt']['timeZone']));
//        if (strlen($timestamp) > 10) {
//            $date->setTimestamp($timestamp / 1000);
//        } else {
//            $date->setTimestamp($timestamp);
//        }
//        if ($isDate) {
//            return $date->format(DefaultEnum::DATE_FORMAT_BIRTDAY);
//        }
//        return $date->format(DefaultEnum::DATE_FORMAT);
//    }

    public static function ConvertIntToIso8601($timestamp)
    {
        if (empty($timestamp)) {
            return '';
        }
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone(Yii::$app->params['gmt']['timeZone']));
        $date->setTimestamp($timestamp);
        return $date->format(\DateTime::ATOM);
    }

//    public static function ConvertIntToDateExcel($timestamp)
//    {
//        if (empty($timestamp)) {
//            return '';
//        }
//        $date = new \DateTime();
//        $date->setTimezone(new \DateTimeZone(Yii::$app->params['gmt']['timeZone']));
//        $date->setTimestamp($timestamp);
//        return $date->format(DefaultEnum::DATE_FORMAT_EXCEL);
//    }

//    /**
//     *
//     * @param string $str
//     * @param boolean $isDate
//     * @param boolean $isBeginDay
//     * @param boolean $isEndDay
//     * @return int
//     */
//    public static function ConvertDateToInt($str, $isDate = false, $isBeginDay = false, $isEndDay = false)
//    {
//        if (empty($str)) {
//            return 0;
//        }
//        $date = null;
//        if ($isDate) {
//            $date = \DateTime::createFromFormat(DefaultEnum::DATE_FORMAT_BIRTDAY, $str, new \DateTimeZone(Yii::$app->params['gmt']['timeZone']));
//
//            if ($date) {
//                if ($isBeginDay) {
//                    $date->setTime(0, 0);
//                }
//                if ($isEndDay) {
//                    $date->setTime(23, 59, 59);
//                }
//            }
//        } else {
//            $date = \DateTime::createFromFormat(DefaultEnum::DATE_FORMAT_SEARCH, $str, new \DateTimeZone(Yii::$app->params['gmt']['timeZone']));
//        }
//        if (!$date) return 0;
//        return (int)Yii::$app->formatter->asTimestamp($date);
//    }

    public static function ConvertDateToIso8601($str, $isDate = false)
    {
        return self::ConvertIntToIso8601(self::ConvertDateToInt($str, $isDate));
    }

    public static function ConvertIso8601ToDate($str, $isDate = false)
    {
        if (empty($str)) {
            return "";
        }
        return self::ConvertIntToDate(strtotime($str), $isDate);
    }

    /**
     * Convert a number to word text vietnamese
     * @param  $number
     * @return string
     */
    public static function ConvertNumberToWord($number)
    {
        $hyphen = ' ';
        $conjunction = '  ';
        $separator = ' ';
        $negative = '??m ';
        $decimal = ' ph???y ';
        $dictionary = array(
            0 => 'kh??ng',
            1 => 'm???t',
            2 => 'hai',
            3 => 'ba',
            4 => 'b???n',
            5 => 'n??m',
            6 => 's??u',
            7 => 'b???y',
            8 => 't??m',
            9 => 'ch??n',
            10 => 'm?????i',
            11 => 'm?????i m???t',
            12 => 'm?????i hai',
            13 => 'm?????i ba',
            14 => 'm?????i b???n',
            15 => 'm?????i n??m',
            16 => 'm?????i s??u',
            17 => 'm?????i b???y',
            18 => 'm?????i t??m',
            19 => 'm?????i ch??n',
            20 => 'hai m????i',
            30 => 'ba m????i',
            40 => 'b???n m????i',
            50 => 'n??m m????i',
            60 => 's??u m????i',
            70 => 'b???y m????i',
            80 => 't??m m????i',
            90 => 'ch??n m????i',
            100 => 'tr??m',
            1000 => 'ng??n',
            1000000 => 'tri???u',
            1000000000 => 't???',
            1000000000000 => 'ngh??n t???',
            1000000000000000 => 'ng??n tri????u tri????u',
            1000000000000000000 => 't??? t???'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error('convertNumberToWord only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
            return false;
        }

        if ($number < 0) {
            return $negative . self::ConvertNumberToWord(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . self::ConvertNumberToWord($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = self::ConvertNumberToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= self::ConvertNumberToWord($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
    }

    public static function formatSecondsToCountdown($second)
    {
        if (!$second) return '';
        if ($second < 0) return '00:00';
        $seconds = floor($second % 60);
        $minutes = $second >= 3600 ? floor(($second / 60) % 60) : floor($second / 60);
        $hours = floor($second / 3600);
        return ($hours ? ($hours >= 10 ? $hours : '0' . $hours) . ":" : '') . ($minutes >= 10 ? $minutes : '0' . $minutes) . ":" . ($seconds >= 10 ? $seconds : '0' . $seconds);
    }
}
