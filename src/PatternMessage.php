<?php
namespace Karo0420\Smspanel;

class PatternMessage extends BaseMessage
{
    public function type()
    {
        return BaseMessage::TYPE_PATTERN;
    }
}