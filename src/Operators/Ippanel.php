<?php
namespace Karo0420\Smspanel\Operators;

use Karo0420\Smspanel\BaseMessage;
use Karo0420\Smspanel\BaseSMS;

class Ippanel extends BaseSMS
{
    public function send(array $to, BaseMessage $message)
    {

        $username = $this->config['username'];
        $password = $this->config['password'];
        $from     = $this->config['sender'];

        $messageBody = $message->getMessage();

        switch ($message->type()) {
            case BaseMessage::TYPE_PATTERN:
                $input_data = $messageBody['params'];
                $url = "https://ippanel.com/patterns/pattern?username=". $username . 
                    "&password=" . urlencode($password) . 
                    "&from=$from&to=" . json_encode($to) . 
                    "&input_data=" . urlencode(json_encode($input_data)) . 
                    "&pattern_code=".$messageBody['id'];
                break;
            case BaseMessage::TYPE_TEXT:
                $url = "https://ippanel.com/services.jspd";
                $input_data = [
                    'uname'=> $username,
                    'pass'=> $password,
                    'from'=> $from,
                    'message'=> $messageBody['text'],
                    'to'=> json_encode($to),
                    'op'=> 'send'
                ];
                break;
            default:
                # code...
                break;
        }

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);

        $response = json_decode($response);
		$res_code = $response[0];
		$res_data = $response[1];

        return $response;
    }
}