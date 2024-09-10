<?php
namespace App\Enums;

enum CartStatus: string
{
    case OnlyDisabled = 'with';
    case NotDisabled = 'not';
    case All = 'all';
}