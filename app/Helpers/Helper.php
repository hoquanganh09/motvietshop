<?php

function getLogo(): string
{
    return asset('images/falcon.png');
}

function getUserAvatar(): string
{
    return asset('images/user.webp');
}

function getDefaultImage()
{
    return asset('images/blank-image.svg');
}

function formatMoney($money)
{
    return number_format($money, 0, ',', '.') . ' đ';
}

function getCartTotal()
{
    $total = 0;

    foreach (session()->get('cart', []) as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return $total;
}

function getCartSavingTotal()
{
    $total = 0;

    foreach (session()->get('cart', []) as $item) {
        if ($item['is_sale']) {
            $total += ($item['old_price'] - $item['price']) * $item['quantity'];
        }
    }

    return $total;
}

function getCartCount()
{
    return count(session()->get('cart', []));
}