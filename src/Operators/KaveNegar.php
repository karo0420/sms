<?php
namespace Karo0420\Smspanel\Operators;

use Karo0420\Smspanel\BaseMessage;
use Karo0420\Smspanel\BaseSMS;
use Kavenegar\Exceptions\ApiException;

class KaveNegar extends BaseSMS
{
    public function send(array $to, BaseMessage $message)
    {
        $api = new \Kavenegar\KavenegarApi($this->config['api_key']);
        
        // $url = 'https://api.kavenegar.com/v1/' . $this->config['apikey'] . '/sms/send.json';
        $messageBody = $message->getMessage();
        switch ($message->type()) {
            case BaseMessage::TYPE_PATTERN:
                break;
            case BaseMessage::TYPE_TEXT:
                $api->Send($this->config['sender'], implode(',', $to), $messageBody['text']);
                break;
            default:
                # code...
                break;
        }
    }
}