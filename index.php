<?php

use Karo0420\Smspanel\SMSfactory;
use Karo0420\Smspanel\TextMessage;

require './vendor/autoload.php';

# create farazsms from factory
$sms = SMSfactory::create('kavenegar', [
    'api_key' => 'dfghj',
    'sender' => '1343'
]);



# send sms 
try {
    $sms->send(
        ['09357999961'], 
        new TextMessage(['text' => 'Mokhlesam'])
    );
} catch (\Exception $e) {
    echo $e->getMessage();
}
