<?php
namespace app\components\helper;

use Yii;
use yii\base\BaseObject;


class PayonHelper {
    public $_APP_ID = '10000002670stnYJbSM';
    public $_MC_ID = 10000002670;
    public $_MC_AUTH_USER = 'checkout';
    public $_MC_AUTH_PASS = '123456';
    public $_API_APP_SECRET_KEY = "SRsreL2f7AEgWsFGoyccNa";
    public $_URL_API = "https://dev-api-merchant.payon.vn/v1/merchant/";


    function CreateOrderPaynow($param)
    {
        $data = $param;
        echo '<pre>';
        print_r("==> Param request:");
        print_r($data);
        $data = json_encode($data);
        $crypto = new PayonEncrypt($this->_API_APP_SECRET_KEY);
        $data = $crypto->Encrypt($data);
        $checksum = md5($this->_APP_ID . $data . $this->_API_APP_SECRET_KEY);
        $bodyPost = array(
            'app_id' => $this->_APP_ID,
            'data' => $data,
            'checksum' => $checksum,
        );
        $result = $this->call($bodyPost, "createOrderPaynow");
        return $result;
    }

    function CheckPayment($input)
    {
        $data = array(
            'merchant_request_id' => $input["merchant_request_id"],
        );
        echo '<pre>';
        print_r("==> Param request:");
        print_r($data);
        $data = json_encode($data);
        $crypto = new PayonEncrypt($this->_API_APP_SECRET_KEY);
        $data = $crypto->Encrypt($data);
        $checksum = md5($this->_APP_ID . $data . $this->_API_APP_SECRET_KEY);
        $bodyPost = array(
            'app_id' => $this->_APP_ID,
            'data' => $data,
            'checksum' => $checksum,
        );
        $result = $this->call($bodyPost, "checkPayment");
        return $result;
    }

    function GetBankInstallment($param = "")
    {
        $data = array(
        );
        $data = json_encode($data);
        $crypto = new PayonEncrypt($this->_API_APP_SECRET_KEY);
        $data = $crypto->Encrypt($data);
        $checksum = md5($this->_APP_ID . $data . $this->_API_APP_SECRET_KEY);
        $bodyPost = array(
            'app_id' => $this->_APP_ID,
            'data' => $data,
            'checksum' => $checksum,
        );
        $result = $this->call($bodyPost, "getBankInstallment");
        return $result;
    }

    function getFee($data)
    {
        $data = json_encode($data);
        $crypto = new PayonEncrypt($this->_API_APP_SECRET_KEY);
        $data = $crypto->Encrypt($data);
        $checksum = md5($this->_APP_ID . $data . $this->_API_APP_SECRET_KEY);
        $bodyPost = array(
            'app_id' => $this->_APP_ID,
            'data' => $data,
            'checksum' => $checksum,
        );
        $result = $this->call($bodyPost, "getFeeInstallment");
        return $result;
    }

    function createOrderInstallment($data)
    {
        $data = json_encode($data);
        $crypto = new PayonEncrypt($this->_API_APP_SECRET_KEY);
        $data = $crypto->Encrypt($data);
        $checksum = md5($this->_APP_ID . $data . $this->_API_APP_SECRET_KEY);
        $bodyPost = array(
            'app_id' => $this->_APP_ID,
            'data' => $data,
            'checksum' => $checksum,
        );
        $result = $this->call($bodyPost, "createOrderInstallment");
        return $result;
    }

    public function Call($params, $fnc)
    {
//        echo '<pre>';
//        print_r("==> Body Post:");
//        print_r($params);
//        echo $this->_URL_API . $fnc;
        $curl = curl_init($this->_URL_API . $fnc);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_USERPWD, $this->_MC_AUTH_USER . ':' . $this->_MC_AUTH_PASS);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json')
        );
        $response = curl_exec($curl);
        $resultStatus = curl_getinfo($curl);
        if ($resultStatus['http_code'] == 200) {
            //echo $response;
            $data = json_decode($response, true);
            return $data;
        } else {
            echo 'Call Failed ' . print_r($resultStatus);
        }
    }
}