<?php
namespace App\Enums;

enum ThongKeType: string
{
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case THREE_MONTHS = 'three_months';
    case YEAR = 'year';
}