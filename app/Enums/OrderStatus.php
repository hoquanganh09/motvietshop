<?php
namespace App\Enums;

enum OrderStatus: int
{
    case CANCEL = 1;
    case PENDING = 2;
    case PROCESSING = 3;
    case SHIPPING = 4;
    case SHIPPED = 5;
    case COMPLETED = 6;
}