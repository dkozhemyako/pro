<?php

namespace App\Enums;


enum PaymentsEnum: int
{
    case STRIPE = 2;
    case PAYPAL = 1;
    case LIQPAY = 3;

}
