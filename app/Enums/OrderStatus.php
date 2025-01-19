<?php

namespace App\Enums;

enum OrderStatus: int
{
    case Pending = 1;
    case Confirmed = 2;
    case Sent = 3;
    case Completed = 4;
    case Canceled = 5;
}
