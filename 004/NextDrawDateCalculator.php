<?php

/**
 * Class NextDrawDateCalculator
 *
 * Draw takes place twice per week, on Tuesday and Sunday at 9.30 pm. This class is for calculate the next valid draw
 * date by a given time or default current time.
 *
 */
class NextDrawDateCalculator
{
    /**
     * Get next valid draw date
     *
     * @param null $checkingTime
     * @return string
     */
    public static function get($checkingTime = null)
    {
        $checkingTime = date('Y-m-d H:i:s',
                             is_null($checkingTime) ? time() : strtotime($checkingTime));

        try {
            $date = new DateTime($checkingTime);
        } catch(Exception $e) {
            return $e->getMessage();
        }

        $dayInt = intval($date->format('N')); // get int value for day of week
        $hourInt = intval($date->format('G')); // get int value for hour of day
        $minuteInt = intval($date->format('i')); // get int value for minute of hour

        if ($dayInt < 2 || ($dayInt === 2 && ($hourInt < 21 || ($hourInt === 21 && $minuteInt < 30)))) {
            // if it is Monday, or Tuesday but before 9:30pm
            // set it to be this Tuesday base on checking time
            $date->modify('this Tuesday');
        } elseif ($dayInt === 7 && ($hourInt > 21 || ($hourInt === 21 && $minuteInt >= 30))) {
            // if it is Sunday but after 9:30pm
            // set it to be next Tuesday base on checking time
            $date->modify('next Tuesday');
        } else {
            // set it to be this saturday base on checking time
            $date->modify('this Sunday');
        }

        return $date->format('l, jS F, Y');
    }
}