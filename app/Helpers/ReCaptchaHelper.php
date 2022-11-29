<?php
/**
@VERSION: 0.1, ReCaptcha
 */

namespace App\Helpers;

use Illuminate\Http\Request;

class ReCaptchaHelper
{
    private $secretKey = '6LdcjQ8jAAAAAOsfrkZ04JIHIVg_xn5Kn1n9yojK';
    private $captchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

    public function check($recaptchaResponse, $userIp){
       //TODO: Может передавать реквекс а тут уже получать g-recaptcha-response и $request->ip()

       $url = $this->captchaUrl."?secret=".$this->secretKey."&response=".$recaptchaResponse."&remoteip=".$userIp;

       $curl = curl_init();
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_TIMEOUT, 10);
       curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
       $curlData = curl_exec($curl);
       curl_close($curl);
       $curlData = json_decode($curlData, true);

       if($curlData['success']) {
           return true;
       }

       return false;
    }

}