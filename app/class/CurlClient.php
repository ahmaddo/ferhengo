<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 11.04.2017
 * Time: 21:27
 */
namespace ferhengo\curl;

class CurlClient {

    protected static function culrCall($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl,array(
            CURLOPT_HTTPGET,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_URL => $url
        ));
        $response = curl_exec($curl);
        return $response;
    }

    static function callLink($link)
    {
        return self::culrCall($link);
    }
}


