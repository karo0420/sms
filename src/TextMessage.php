<?php
namespace Karo0420\Smspanel;

class TextMessage extends BaseMessage
{

    public function type()
    {
        return BaseMessage::TYPE_TEXT;
    }

}