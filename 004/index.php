<?php
require_once 'NextDrawDateCalculator.php';

// Test cases
printf("Next draw date for current time is: %s", NextDrawDateCalculator::get());
printf("<br><br>");
printf("Next draw date for 2019-04-22 19:10:00 is: %s", NextDrawDateCalculator::get('2019-04-22 19:10:00'));
printf("<br><br>");
printf("Next draw date for 2019-04-23 21:32:00 is: %s", NextDrawDateCalculator::get('2019-04-23 21:32:00'));
printf("<br><br>");
printf("Next draw date for 2019-04-26 19:12:00 is: %s", NextDrawDateCalculator::get('2019-04-26 19:12:00'));
printf("<br><br>");
printf("Next draw date for 2019-04-28 21:23:00 is: %s", NextDrawDateCalculator::get('2019-04-28 21:23:00'));
printf("<br><br>");
printf("Next draw date for 2019-04-28 21:35:00 is: %s", NextDrawDateCalculator::get('2019-04-28 21:35:00'));
