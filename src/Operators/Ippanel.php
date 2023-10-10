<?php
namespace Karo0420\Smspanel\Operators;

use Karo0420\Smspanel\BaseMessage;
use Karo0420\Smspanel\BaseSMS;

class Ippanel extends BaseSMS
{
    public function send(array $to, BaseMessage $message)
    {
        $url = 'http://rest.ippanel.com/v1/messages';
        $messageBody = $message->getMessage();
        $data = array(
            "originator" => $this->config['sender'],
            "recipients" => $to,
            "message" => $messageBody['text']
        );


        $jsonData = json_encode($data);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
            'Authorization: AccessKey ' . $this->config['api_key']
        ));

        $response = curl_exec($ch);
        curl_close($ch);
    }
}