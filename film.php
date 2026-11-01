<?php
require_once "fungsi.php";

$judul = "Semua Film - Cinemora";
$genre = $_GET["genre"] ?? "";

$films = $modelFilm->semua($genre);
$genres = $modelFilm->daftarGenre();

require "header.php";
?>

<div class="page-title">
    <p class="eyebrow">KOLEKSI CINEMORA</p>
    <h1>Semua Film</h1>
</div>

<div class="filters">
    <a href="film.php"
        class="chip <?= $genre === "" ? "active" : "" ?>">
        Semua
    </a>
    <?php foreach ($genres as $g): ?>

        <a href="film.php?genre=<?= urlencode($g["genre"]) ?>"
            class="chip <?= $genre === $g["genre"] ? "active" : "" ?>">

            <?= e($g["genre"]) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="film-grid">
    <?php foreach ($films as $film): ?>
        <article class="film-card">
            <a href="detail.php?id=<?= $film["id_film"] ?>">
                <div class="poster <?= e($film["warna"]) ?>">
                    <?= posterIsi($film["warna"]) ?>
                </div>
            </a>

            <h3><?= e($film["judul"]) ?></h3>

            <p class="muted">
                <?= e($film["genre"]) ?>
                ·
                <?= (int)$film["durasi"] ?> menit
            </p>

            <a href="detail.php?id=<?= $film["id_film"] ?>"
                class="btn btn-block">
                Beli Tiket
            </a>

        </article>

    <?php endforeach; ?>

</div>

<?php if (!$films): ?>

    <p class="empty">
        Belum ada film untuk kategori ini.
    </p>

<?php endif; ?>

<?php require "footer.php"; ?>