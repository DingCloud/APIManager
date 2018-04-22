<?php
/**
 * Http全局通信类库（仅POST）
 * @package DingStudio/HttpClient
 * @subpackage Passport/CrossDomain
 * @author DingStudio
 * @copyright 2012-2018 All Rights Reserved
 */

class Client {

    public static function doPostRequest($address, $post_array = array()) {
        $cookie_jar = dirname(__FILE__).'/'.$_COOKIE['PHPSESSID'];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $address);
        //curl_setopt($curl, CURLOPT_COOKIE, 'JSESSIONID='.$_COOKIE['PHPSESSID']);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_jar);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_array);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    public static function doGetRequest($address) {
        $cookie_jar = dirname(__FILE__).'/'.$_COOKIE['PHPSESSID'];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $address);
        //curl_setopt($curl, CURLOPT_COOKIE, 'JSESSIONID='.$_COOKIE['PHPSESSID']);
        if (file_exists($cookie_jar)) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_jar);
        }
        else {
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar);
        }
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}