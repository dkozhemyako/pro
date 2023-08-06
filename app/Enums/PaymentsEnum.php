<?php

namespace App\Enums;


enum PaymentsEnum: int
{
    case STRIPE = 1;
    case PAYPAL = 2;
    case LIQPAY = 3;

}
