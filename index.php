<?php

use Karo0420\Smspanel\SMSfactory;
use Karo0420\Smspanel\TextMessage;

require './vendor/autoload.php';

# create farazsms from factory
$sms = SMSfactory::create(
    'farazsms', 
    [
        'username' => '09361222770', 
        'password' => 'kWyE7@Xhnq',
        'send_from' => '5000' //+983000505
    ]
);

# send sms 
$sms->send(
    ['09123456789'], 
    new TextMessage(['text' => 'Mokhlesam'])
);

