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
                // $url = 'https://ippanel.com/services.jspd';
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

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        );

        $fields_string = "";
        if (!is_null($input_data))
            $fields_string = http_build_query($input_data);

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);
        $response = curl_exec($handle);
        curl_close($handle);

        $response = json_decode($response);
		$res_code = $response[0];
		$res_data = $response[1];
        if ($res_code !== 0)
            throw new \Exception($res_data, $res_code);
        return $response;
    }
}