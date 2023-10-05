<?php
namespace Karo0420\Smspanel;

// use Illuminate\Support\Facades\Log;

class FarazSMS extends BaseSMS
{

    private $url = 'https://ippanel.com/services.jspd';

    public function credit()
    {
        $param = [
            'uname'=> $this->config['username'],
            'pass'=> $this->config['password'],
            'op'=> 'credit'
        ];
        $res = $this->client->request('post', $this->url, [
            'form_params' => $param
        ]);
        return $res->getBody()->getContents(); //"500073.57871"
    }

    public function send(array $to, $message)
    {
        $username = $this->config['username'];
        $password = $this->config['password'];
        $from     = $this->config['send_from'];

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
		
		
		echo $response;


        // $res = $this->client->request('post', $url, [
        //     'form_params' => $input_data
        // ]);

        // Log::info("SMS-TO: {$to} - {$messageBody['id']} - BODY: {$res->getBody()->getContents()}");
        // $res->getBody()->getContents();
    }
}