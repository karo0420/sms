<?php
namespace Karo0420\Smspanel;

abstract class BaseMessage
{

    const TYPE_PATTERN = 1;
    const TYPE_TEXT = 2;

    protected $messageBody;
    
    public function __construct(array $messageBody)
    {
        $this->messageBody = $messageBody;
    }

    public function getMessage()
    {
        return $this->messageBody;
    }

    public abstract function type();

}