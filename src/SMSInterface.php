<?php
namespace Karo0420\Smspanel;

interface SMSInterface
{
    public function send(array $to, BaseMessage $message);
}