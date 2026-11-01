<?php
require_once "fungsi.php";

$id = (int)($_GET["id"] ?? 0);

$film = $modelFilm->cari($id);

if (!$film) {
    die("Film tidak ditemukan.");
}

$jadwal = $modelJadwal->milikFilm($id);

$judul = "Detail Film - BioskopKu";

require "header.php";
?>

<section class="detail-layout">

    <div class="detail-poster poster <?= e($film["warna"]) ?>">
        <span>POSTER</span>
    </div>

    <div class="detail-content">

        <p class="eyebrow">DETAIL FILM</p>

        <h1><?= e($film["judul"]) ?></h1>

        <p class="muted">
            <?= e($film["genre"]) ?>
            · <?= (int)$film["durasi"] ?> menit
            · <?= e($film["rating"]) ?>
        </p>

        <p>
            <?= nl2br(e($film["sinopsis"])) ?>
        </p>

        <h3>Pilih Jadwal</h3>

        <div class="schedule-list">

            <?php foreach ($jadwal as $j): ?>

                <div class="schedule-card">

                    <div>
                        <strong>
                            <?= date("D, d M", strtotime($j["tanggal"])) ?>
                        </strong>

                        <p class="muted">
                            <?= e($j["studio"]) ?>
                            ·
                            <?= e($j["jam"]) ?>
                        </p>
                    </div>

                    <div class="schedule-price">

                        <?= $modelJadwal->rupiah($j["harga"]) ?>

                    </div>

                    <a href="kursi.php?id_jadwal=<?= $j["id_jadwal"] ?>"
                        class="btn">

                        Pilih Kursi

                    </a>

                </div>

            <?php endforeach; ?>

        </div>

        <?php if (!$jadwal): ?>

            <p class="empty">
                Belum ada jadwal tersedia.
            </p>

        <?php endif; ?>

    </div>

</section>

<?php require "footer.php"; ?>