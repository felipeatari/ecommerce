<?php

namespace App\Enums;

enum PaymentType: int
{
    case Pix = 1;
    case Cart = 2;
}
