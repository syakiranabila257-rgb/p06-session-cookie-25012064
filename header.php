<?php

if (isset($theme)) {
    $currentTheme = $theme;
} else {
    $currentTheme = 'light';
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php
        if (isset($title)) {
            echo e($title);
        } else {
            echo 'Toko Sederhana';
        }
        ?>
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="theme-<?php echo e($currentTheme); ?>">

<header class="header">

    <div class="container nav">

        <a
            class="brand"
            href="index.php"
        >
            🛒 Toko Sederhana
        </a>

        <nav>

            <a href="index.php">
                Katalog
            </a>

            <a href="cart.php">
                Keranjang
                (<?php
                    echo cartCount(
                        isset($_SESSION['cart'])
                            ? $_SESSION['cart']
                            : array()
                    );
                ?>)
            </a>

        </nav>

    </div>

</header>

<main class="container">