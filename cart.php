<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/functions.php';

$products = require __DIR__ . '/data/products.php';

$allowedThemes = ['light', 'dark'];

$theme = $_COOKIE['theme'] ?? 'light';

if (!in_array($theme, $allowedThemes, true)) {
    $theme = 'light';
}

$flash = pullFlash();

$cart = $_SESSION['cart'];

$total = 0;

$title = 'Keranjang';

require __DIR__ . '/components/header.php';
?>

<h1>
    Keranjang Belanja
</h1>

<?php if ($flash !== null): ?>

    <div class="flash">
        <?= e($flash) ?>
    </div>

<?php endif; ?>


<?php if ($cart === []): ?>

    <div class="empty">

        <p>
            Keranjang masih kosong.
        </p>

        <a
            class="button"
            href="index.php"
        >
            Kembali ke Katalog
        </a>

    </div>

<?php else: ?>

    <div class="cart-box">

        <?php foreach ($cart as $id => $quantity): ?>

            <?php

            if (!isset($products[$id])) {
                continue;
            }

            $product = $products[$id];

            $subtotal =
                $product['harga']
                * (int) $quantity;

            $total += $subtotal;

            ?>

            <div class="cart-row">

                <div>

                    <strong>
                        <?= e($product['nama']) ?>
                    </strong>

                    <span>

                        <?= (int) $quantity ?>

                        ×

                        Rp<?= number_format(
                            $product['harga'],
                            0,
                            ',',
                            '.'
                        ) ?>

                    </span>

                </div>

                <div>

                    <strong>

                        Rp<?= number_format(
                            $subtotal,
                            0,
                            ',',
                            '.'
                        ) ?>

                    </strong>

                    <form
                        action="actions.php"
                        method="post"
                        class="inline-form"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="remove"
                        >

                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int) $id ?>"
                        >

                        <button
                            type="submit"
                            class="danger"
                        >
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        <?php endforeach; ?>


        <div class="total">

            <span>
                Total
            </span>

            <strong>

                Rp<?= number_format(
                    $total,
                    0,
                    ',',
                    '.'
                ) ?>

            </strong>

        </div>


        <div class="actions">

            <a
                class="button secondary"
                href="index.php"
            >
                Tambah Produk
            </a>

            <form
                action="actions.php"
                method="post"
            >

                <input
                    type="hidden"
                    name="action"
                    value="clear"
                >

                <button
                    type="submit"
                    class="danger"
                >
                    Kosongkan Keranjang
                </button>

            </form>

        </div>

    </div>

<?php endif; ?>


<?php require __DIR__ . '/components/footer.php'; ?>