<?php

namespace App\Services;

use Carbon\Carbon;

class Log
{
    public static function info(string $message): void
    {
        echo self::getPrefix() . $message . "\n";
    }

    public static function error(string $message): void
    {
        error_log(self::getPrefix() . $message);
    }

    public static function getPrefix(): string
    {
        $pid = getmypid();
        $time = Carbon::now()->toDateTimeString();

        return "[$pid/$time] ";
    }
}