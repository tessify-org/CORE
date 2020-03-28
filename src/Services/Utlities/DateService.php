<?php

namespace Tessify\Core\Services\Utilities;

use Carbon\Carbon;

class DateService
{
    public function parse($date, $delimiter)
    {
        $mainParts = explode(" ", $date);

        if (count($mainParts) == 1)
        {
            $parts = explode($delimiter, $date);
            $date = Carbon::create($parts[2], $parts[1], $parts[0]);
        }
        else
        {
            $date = $mainParts[0];
            $time = $mainParts[1];
            $dateParts = explode($delimiter, $date);
            $timeParts = explode(":", $time);
            if (strlen($dateParts[0]) == 4)  {
                $date = Carbon::create($dateParts[0], $dateParts[1], $dateParts[2], $timeParts[0], $timeParts[1], $timeParts[2]);
            } else {
                $date = Carbon::create($dateParts[2], $dateParts[1], $dateParts[0], $timeParts[0], $timeParts[1], $timeParts[2]);
            }
        }

        return $date;
    }
}