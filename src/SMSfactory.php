<?php
# sent correct namespace
namespace Karo0420\Smspanel;

use GuzzleHttp\Client;
use Karo0420\Smspanel\Operators\Ippanel;
use Karo0420\Smspanel\Operators\KaveNegar;

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
            case 'ippanel':
                return new Ippanel(new Client(), $config);
                break;
            case 'kavenegar':
                return new KaveNegar(new Client(), $config);
                break;
            default:
                # code...$config
                break;
        }
    }
}