<?php

namespace App\Flow;

use Exception;

class Flow{

    protected $apikey;
    protected $secreykey;

    public function __construct()
    {
        $this->apikey = '3A5F16F9-16C6-47FA-8BC1-771D388LFF9C';
        $this->secreykey = '1e7fbfbc4bbc60cd4f586ff4d5cc428f6178b62d';
    }

    public function send($services, $params,$method = "GET"){

        $method = strtoupper($method);
        $url = "https://sandbox.flow.cl/api/" . $services;
        $params = array("apiKey"=>$this->apikey) + $params;
        $data = $this->getPack($params,$method);
        $sign = $this->sign($params);

        if($method == "GET"){
            $response = $this->httpGet($url, $data, $sign);
        }else{
            $response = $this->httpPost($url, $data, $sign);
        }

        if(isset($response["info"])){
            $code = $response["info"]["http_code"];
            $body = json_decode($response["output"],true);
            if($code == "200"){
                return $body;
            }elseif(in_array($code, array("400","401"))){
                throw new Exception($body["message"],$body["code"]);
            }else{
                throw new Exception("Ocurrio un error. HTTP_CODE:" .$code, $code);
            }
        }else{
            throw new Exception("Ocurrio un error.");
        }
    }

    public function setKey($apikey, $secreykey){
        $this->apikey = $apikey;
        $this->secreykey =  $secreykey;
    }

    private function getPack($params, $method){
        $keys = array_keys($params);
        sort($keys);
        $data = "";
        foreach ($keys as $key) {
            if($method == "GET"){
                $data .= "&" . rawurlencode($key) . "=" . rawurlencode($params[$key]);
            }else{
                $data .= "&" . $key . "=" . $params[$key];
            }
        }
        
        return substr($data,1);
    }

    private function sign($params){

        $keys = array_keys($params);
        sort($keys);
        $toSign = "";

        foreach ($keys as $key) {

            $toSign .= "&" . $key . "=" . $params[$key];

        }

        $toSign = substr($toSign, 1);
        if(!function_exists("hash_hmac")){
            throw new Exception("Function hash_hmac no existe", 1);
        }

        return hash_hmac('sha256', $toSign, $this->secreykey);

    }

    private function httpGet($url,$data,$sign){
        $url = $url . "?" .$data . "&s=" .$sign;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);

        if($output === false){
            $error = curl_error($ch);
            throw new Exception($error,1);
        }

        $info = curl_getinfo($ch);
        curl_close($ch);

        return array("output" => $output, "info" => $info);


    }

    private function httpPost($url,$data,$sign){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data . "&s=" .$sign);
        $output = curl_exec($ch);

        if($output === false){
            $error = curl_error($ch);
            throw new Exception($error,1);
        }

        $info = curl_getinfo($ch);
        curl_close($ch);

        return array("output" => $output, "info" => $info);

    }

    public function read_confirm() {

        if(!isset($_POST['token'])) {

            throw new Exception('Invalid response');
        }

        $token = $_POST['token'];


        return $token;

    }

    public function read_retorno() {

        if(!isset($_POST['token'])) {

            throw new Exception('Invalid response');
        }

        $token = $_POST['token'];


        return $token;

    }


}
