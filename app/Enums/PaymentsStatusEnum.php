<?php

namespace App\Enums;


enum PaymentStatusEnum: int
{
    case COMPLETED = 1;
    case ORDER_NOT_APPROVED = 2;
    case ORDER_ALREADY_CAPTURED = 3;

}
