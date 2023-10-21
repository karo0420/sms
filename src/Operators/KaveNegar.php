<?php
namespace Karo0420\Smspanel\Operators;

use Exception;
use Karo0420\Smspanel\BaseMessage;
use Karo0420\Smspanel\BaseSMS;
use Kavenegar\Exceptions\ApiException;

class KaveNegar extends BaseSMS
{
    public function send(array $to, BaseMessage $message)
    {        
        $messageBody = $message->getMessage();
        switch ($message->type()) {
            case BaseMessage::TYPE_PATTERN:
                $data = array(
                    "receptor" => $to[0],
                    "template" => $messageBody['id'],
                );

                $data = array_merge($data, $messageBody['params']);
            
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded',
                    'charset: utf-8'
                );

                $fields_string = "";
                if (!is_null($data)) {
                    $fields_string = http_build_query($data);
                }

                $handle = curl_init();
                $url = "https://api.kavenegar.com/v1/".$this->config['api_key']."/verify/lookup.json/";
                curl_setopt($handle, CURLOPT_URL, $url);
                curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);
            
                $response = curl_exec($handle);
                curl_close($handle);
                $res = json_decode($response);
                if ($res->return->status != 200);
                    throw new \Exception($res->return->message, $res->return->status);
                break;
            case BaseMessage::TYPE_TEXT:
                $api = new \Kavenegar\KavenegarApi($this->config['api_key']);
                $api->Send($this->config['sender'], implode(',', $to), $messageBody['text']);
                break;
            default:
                # code...
                break;
        }
    }
}