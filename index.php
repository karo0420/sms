<?php

use Karo0420\Smspanel\SMSfactory;
use Karo0420\Smspanel\TextMessage;
use Karo0420\Smspanel\PatternMessage;

require './vendor/autoload.php';

# create farazsms from factory
$sms = SMSfactory::create('kavenegar', [
    'username' => '',
    'password' => '',
    'api_key' => '',
    'sender' => '',
]);



# send sms 
try {
    $sms->send(
        ['09357999961'], 
        new TextMessage(['text' => 'Mokhlesam'])
        // new PatternMessage(['id' => 123, 'params' => ['asd'=>'ads']])
    );
} catch (\Exception $e) {
    echo $e->getCode().':'.$e->getMessage();
}
