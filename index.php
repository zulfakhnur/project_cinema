<?php
require_once "fungsi.php";

$judul = "Beranda - Cinemora";
$films = $modelFilm->semua("", "now_showing");

require "header.php";
?>

<section class="hero">
    <div>
        <p class="eyebrow">SELAMAT DATANG DI CINEMORA</p>

        <h1>
            Pilih film, pilih kursi,
            langsung nonton.
        </h1>

        <p>
            Nikmati pengalaman menonton film favorit
            dengan proses pemesanan yang mudah.
        </p>

        <a href="film.php" class="btn">
            Lihat Semua Film
        </a>
    </div>

        <?php if ($films): ?>
        <a href="detail.php?id=<?= $films[0]["id_film"] ?>"
            class="hero-poster poster <?= e($films[0]["warna"]) ?>">
            <?= posterIsi($films[0]["warna"]) ?>
        </a>
    <?php endif; ?>
</section>

<div class="section-heading">
    <div>
        <p class="eyebrow">PILIHAN UNTUKMU</p>
        <h2>Sedang Tayang</h2>
    </div>

    <a href="film.php" class="text-link">
        Lihat semua film →
    </a>
</div>

<div class="film-grid">
    <?php foreach (array_slice($films, 0, 4) as $film): ?>
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

<?php require "footer.php"; ?>