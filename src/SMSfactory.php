<?php
# sent correct namespace
namespace Karo0420\Smspanel;

use GuzzleHttp\Client;

# write a class to create different sms insrance like farazsms
class SMSfactory
{
    # write a function to create different sms insrance like farazsms
    public static function create($sms, $config = [])
    {
        # write a switch case to create different sms insrance like farazsms
        switch ($sms) {
            case 'farazsms':
                return new FarazSMS(new Client(), $config);
                break;
            default:
                # code...$config
                break;
        }
    }
}