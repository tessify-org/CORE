<?php

namespace Tessify\Core\Services\Utilities;

use Carbon\Carbon;

class DateService
{
    public function parse($date, $delimiter)
    {
        $parts = explode($delimiter, $date);
        $date = Carbon::create($parts[2], $parts[1], $parts[0]);
        return $date;
    }
}