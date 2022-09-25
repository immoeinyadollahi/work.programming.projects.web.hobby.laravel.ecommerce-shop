<?php

namespace App\Utilities;

use DateTime;
use Morilog\Jalali\Jalalian;

class Date
{
    public static function formatDate($date = null, $format = "d %B Y")
    {
        return Jalalian::forge($date ?? time())->format($format);
    }
    public static function formatTime($date = null, $format = "H:i")
    {
        return Jalalian::forge($date ?? time())->format($format);
    }
}
