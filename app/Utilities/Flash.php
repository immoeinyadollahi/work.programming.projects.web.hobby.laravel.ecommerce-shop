<?php

namespace App\Utilities;

class Flash
{
    public static function addMessage($message, $level)
    {
        session()->flash("messages", array_merge(session()->get("messages", []), [compact("message", "level")]));
    }
    public static function addMessages($messages, $level = null)
    {
        foreach ($messages as $message) {
            call_user_func_array([self::class, "addMessage"], $level ? [$message, $level] : $message);
        }
    }
}
