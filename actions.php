<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/functions.php';

$products = require __DIR__ . '/data/products.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: index.php');

    exit;
}


$action = isset($_POST['action'])
    ? $_POST['action']
    : '';


$id = filter_input(
    INPUT_POST,
    'id',
    FILTER_VALIDATE_INT
);


/* TAMBAH PRODUK */

if (
    $action === 'add'
    && $id !== false
    && $id !== null
    && isset($products[$id])
) {

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 0;
    }

    $_SESSION['cart'][$id]++;

    setFlash(
        'Produk ditambahkan ke keranjang.'
    );

    header('Location: index.php');

    exit;
}


/* HAPUS PRODUK */

if (
    $action === 'remove'
    && $id !== false
    && $id !== null
    && isset($_SESSION['cart'][$id])
) {

    unset($_SESSION['cart'][$id]);

    setFlash(
        'Produk dihapus dari keranjang.'
    );

    header('Location: cart.php');

    exit;
}


/* KOSONGKAN */

if ($action === 'clear') {

    $_SESSION['cart'] = array();

    setFlash(
        'Keranjang dikosongkan.'
    );

    header('Location: cart.php');

    exit;
}


/* INPUT SALAH */

setFlash(
    'Permintaan tidak valid.'
);

header('Location: index.php');

exit;