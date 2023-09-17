<?php

namespace App\Helpers;

class DateHelper
{
    /**
     * Returns string timestamp in mysql format
     *
     * @return string
     */
    public static function mysqlTimestampNow(): string
    {
        return date('Y-m-d h:m:i', time());
    }
}
