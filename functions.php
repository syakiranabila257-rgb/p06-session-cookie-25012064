<?php

function e($value)
{
    return htmlspecialchars(
        $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

function setFlash($message)
{
    $_SESSION['flash'] = $message;
}

function pullFlash()
{
    if (isset($_SESSION['flash'])) {
        $message = $_SESSION['flash'];

        unset($_SESSION['flash']);

        return $message;
    }

    return null;
}

function cartCount($cart)
{
    return array_sum(
        array_map('intval', $cart)
    );
}