<?php
namespace Karo0420\Smspanel;

use GuzzleHttp\Client;

abstract class BaseSMS implements SMSInterface
{
    const TYPE_PATTERN = 1;
    const TYPE_TEXT = 2;

    const OPERATOR_KAVENEGAR = 'kavenegar';
    const OPERATOR_IPPANEL = 'ippanel';

    protected $client;
    protected $config;
    
    public function __construct(Client $client, array $config = [])
    {
        $this->client = $client;
        $this->config = $config;
    }

}