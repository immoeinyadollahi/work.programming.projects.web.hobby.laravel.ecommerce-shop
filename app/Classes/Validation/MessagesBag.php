<?php

namespace App\Classes\Validation;

class MessagesBag
{
    private $messages = [];

    public function add($message, $level)
    {
        $this->messages[] = [$message, $level];
    }
    public function all()
    {
        return $this->messages;
    }
    public function isNotEmpty()
    {
        return count($this->messages) > 0;
    }
}
