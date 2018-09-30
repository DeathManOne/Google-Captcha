<?php
namespace Google;


use \Google\CaptchaEntity as CaptchaEntity;


class Captcha
{
    const PHP_VERS  =  'php_1.0';


    private $_secret, $_error;


    public function __construct($secret = NULL) { $this->_secret = ( $secret === NULL ) ? NULL : (string) $secret; }


    public function check($response = NULL)
    {
        if ( $this->_secret === null )                        { $this->_error[] = 'missing-input-secret';   }
        if ( $response === null || strlen($response) === 0 )  { $this->_error[] = 'missing-input-response'; }


        if ( $this->_error !== NULL ) { return new CaptchaEntity(['SUCCESS' => FALSE, 'ERROR-CODES' => $this->_error]); }


        $info['v']         =  self::PHP_VERS;
        $info['secret']    =  $this->_secret;
        $info['response']  =  $response;
        $info['remoteip']  =  $_SERVER["REMOTE_ADDR"];


        $url  =  'https://www.google.com/recaptcha/api/siteverify?' . http_build_query($info, '&');


        try
        {
            $curl  =  curl_init();
            curl_setopt($curl, CURLOPT_URL             ,  $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST  ,  FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER  ,  FALSE);
            curl_setopt($curl, CURLOPT_POST            ,  FALSE);
            curl_setopt($curl, CURLOPT_FRESH_CONNECT   ,  TRUE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER  ,  TRUE);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION  ,  TRUE);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT  ,  3);
            curl_setopt($curl, CURLOPT_TIMEOUT         ,  5);
            $data  =  json_decode(curl_exec($curl), TRUE);
            $data  =  new CaptchaEntity($data);
        }
        catch (\Exception $e) { $data = new CaptchaEntity(['SUCCESS' => FALSE,  'ERROR-CODES' => ['error-connection']]); }
        finally
        {
            curl_close($curl);
            return $data;
        }
}
}
