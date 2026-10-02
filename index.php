<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/functions.php';

$products = require __DIR__ . '/data/products.php';

$allowedThemes = array('light', 'dark');

if (isset($_COOKIE['theme'])) {
    $theme = $_COOKIE['theme'];
} else {
    $theme = 'light';
}

if (!in_array($theme, $allowedThemes)) {
    $theme = 'light';
}


/* SIMPAN TEMA */

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['theme'])) {

    $candidate = $_POST['theme'];

    if (in_array($candidate, $allowedThemes)) {

        setcookie(
            'theme',
            $candidate,
            time() + (60 * 60 * 24 * 30),
            '/'
        );

        header('Location: index.php');
        exit;
    }

    setFlash('Tema tidak valid.');

    header('Location: index.php');
    exit;
}


/* FLASH MESSAGE */

$flash = pullFlash();

$title = 'Katalog Produk';

require __DIR__ . '/components/header.php';

?>

<section class="hero">

    <div>

        <h1>Katalog Produk</h1>

        <p>
            Pilih produk yang ingin kamu masukkan
            ke keranjang.
        </p>

    </div>


    <form method="post" class="theme-form">

        <label for="theme">
            Tema:
        </label>

        <select name="theme" id="theme">

            <option
                value="light"
                <?php if ($theme === 'light') echo 'selected'; ?>
            >
                Terang
            </option>

            <option
                value="dark"
                <?php if ($theme === 'dark') echo 'selected'; ?>
            >
                Gelap
            </option>

        </select>

        <button type="submit">
            Simpan Tema
        </button>

    </form>

</section>


<?php if ($flash !== null): ?>

    <div class="flash">
        <?php echo e($flash); ?>
    </div>

<?php endif; ?>


<div class="grid">

    <?php foreach ($products as $id => $product): ?>

        <article class="card">

            <div class="emoji">
                🛍️
            </div>

            <h2>
                <?php echo e($product['nama']); ?>
            </h2>

            <p class="price">

                Rp<?php echo number_format(
                    $product['harga'],
                    0,
                    ',',
                    '.'
                ); ?>

            </p>


            <form
                action="actions.php"
                method="post"
            >

                <input
                    type="hidden"
                    name="action"
                    value="add"
                >

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo (int) $id; ?>"
                >

                <button
                    type="submit"
                    class="button"
                >
                    Tambah ke Keranjang
                </button>

            </form>

        </article>

    <?php endforeach; ?>

</div>


<?php

require __DIR__ . '/components/footer.php';

?>