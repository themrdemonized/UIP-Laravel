<?php


namespace App\Http\Services\SmsSender;

require_once "BEESMS.class.php";

class SmsSender
{
    public static function send($number, $identifier, $sender='uip-dv')
    {
        $formatNumber = str_replace(['(', ')', ' '],'', $number);

        $sms_text = "Ваш идентификатор для участия в аукционе, не сообщайте его никому: $identifier";
        $target = $formatNumber;

        $sms = new BEESMS();

        $result = $sms->post_message($sms_text, $target, $sender);

        return true;
    }
}