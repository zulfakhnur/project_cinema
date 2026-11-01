<?php
require_once "fungsi.php";

wajibLogin();

$idJadwal = (int)($_GET["id_jadwal"] ?? 0);

$jadwal = $modelJadwal->cari($idJadwal);

if (!$jadwal) {
    die("Jadwal tidak ditemukan.");
}

$terisi = $modelBooking->kursiTerisi($idJadwal);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pilihan = array_values(array_unique(array_filter(
        (array)($_POST["kursi"] ?? []),
        function($k) {
            return preg_match('/^[A-F][1-8]$/', $k);
        }
    )));

    try {
        $modelBooking->pesan($_SESSION["user"]["id_user"], $jadwal, $pilihan);
        header("Location: tiket.php");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$judul = "Pilih Kursi - BioskopKu";

require "header.php";
?>

<div class="booking-layout">

    <section class="seat-panel">

        <h2>Pilih Kursi</h2>

        <div class="screen">
            LAYAR
        </div>

        <form method="POST">

            <div class="seat-map">

                <?php foreach (range("F", "A") as $baris): ?>

                    <div class="seat-row">

                        <b><?= $baris ?></b>

                        <?php for ($i = 1; $i <= 8; $i++): ?>

                            <?php $kode = $baris . $i; ?>

                            <?php if (in_array($kode, $terisi)): ?>

                                <span class="seat occupied">
                                    <?= $i ?>
                                </span>

                            <?php else: ?>

                                <label class="seat">

                                    <input type="checkbox"
                                        name="kursi[]"
                                        value="<?= $kode ?>">

                                    <span><?= $i ?></span>

                                </label>

                            <?php endif; ?>

                        <?php endfor; ?>

                    </div>

                <?php endforeach; ?>

            </div>

            <div class="legend">
                <span><i></i> Tersedia</span>
                <span><i class="chosen"></i> Dipilih</span>
                <span><i class="taken"></i> Terisi</span>
            </div>

            <?php if ($error): ?>
                <p class="alert"><?= e($error) ?></p>
            <?php endif; ?>

            <button class="btn btn-block" type="submit">
                Pesan Sekarang
            </button>

        </form>

    </section>

    <aside class="summary">

        <p class="eyebrow">RINGKASAN PESANAN</p>

        <h3><?= e($jadwal["judul"]) ?></h3>

        <p class="muted">
            <?= e($jadwal["studio"]) ?>
            · <?= e($jadwal["jam"]) ?>
        </p>

        <p>
            Harga per kursi:
            <strong class="gold">
                <?= $modelJadwal->rupiah($jadwal["harga"]) ?>
            </strong>
        </p>

    </aside>

</div>

<?php require "footer.php"; ?>