<?php
require_once "fungsi.php";

wajibLogin();

$idUser = $_SESSION["user"]["id_user"];

if (isset($_GET["batal"])) {
    $modelBooking->batal((int)$_GET["batal"], $idUser);
    header("Location: tiket.php");
    exit;
}

$tickets = $modelBooking->milikUser($idUser);

$judul = "Tiket Saya - BioskopKu";

require "header.php";
?>

<div class="page-title">

    <p class="eyebrow">RIWAYAT PEMESANAN</p>

    <h1>Tiket Saya</h1>

</div>

<?php foreach ($tickets as $t): ?>

    <article class="ticket-card">

        <div class="ticket-poster poster poster-red">
            <span>POSTER</span>
        </div>

        <div class="ticket-info">

            <h3><?= e($t["judul"]) ?></h3>

            <p class="muted">
                <?= e($t["studio"]) ?>
                · <?= date("d M", strtotime($t["tanggal"])) ?>
                · <?= e($t["jam"]) ?>
            </p>

            <p class="muted">
                Kursi: <?= e($t["kursi"]) ?>
            </p>

            <p class="muted">
                Kode: <?= e($t["kode_booking"]) ?>
            </p>

        </div>

        <div class="ticket-side">

            <span class="status <?= strtolower($t["status"]) ?>">
                <?= e($t["status"]) ?>
            </span>

            <strong>
                <?= $modelJadwal->rupiah($t["total"]) ?>
            </strong>

            <?php if ($t["status"] === "LUNAS"): ?>

                <a href="tiket.php?batal=<?= $t["id_pemesanan"] ?>"
                    class="btn btn-small"
                    onclick="return confirm('Batalkan tiket ini?')">

                    Batalkan

                </a>

            <?php endif; ?>

        </div>

    </article>

<?php endforeach; ?>

<?php if (!$tickets): ?>

    <p class="empty">
        Kamu belum memiliki tiket.
        <a href="film.php">Cari film sekarang.</a>
    </p>

<?php endif; ?>

<?php require "footer.php"; ?>