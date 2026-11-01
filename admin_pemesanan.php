<?php
require_once "fungsi.php";

wajibAdmin();

$pesanan = $modelBooking->semua();
$judul = "Admin - Data Pemesanan";

require "header.php";
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <h3>BioskopKu Admin</h3>

        <a href="admin.php">Kelola Film</a>
        <a href="admin_jadwal.php">Kelola Jadwal</a>
        <a href="admin_pemesanan.php" class="selected">Data Pemesanan</a>
        <a href="keluar.php">Keluar</a>
    </aside>

    <section class="admin-content">
        <div class="section-heading">
            <h1>Data Pemesanan</h1>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Pemesan</th>
                        <th>Film</th>
                        <th>Jadwal</th>
                        <th>Kursi</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($pesanan as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($p["kode_booking"]) ?></td>
                            <td><?= e($p["pemesan"]) ?></td>
                            <td><?= e($p["judul"]) ?></td>
                            <td>
                                <?= date("d M Y", strtotime($p["tanggal"])) ?>
                                · <?= e($p["jam"]) ?>
                                · <?= e($p["studio"]) ?>
                            </td>
                            <td><?= e($p["kursi"]) ?></td>
                            <td><?= $modelJadwal->rupiah($p["total"]) ?></td>
                            <td>
                                <span class="status <?= strtolower($p["status"]) ?>">
                                    <?= e($p["status"]) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <?php if (!$pesanan): ?>
            <p class="empty">Belum ada pemesanan.</p>
        <?php endif; ?>
    </section>
</div>
<?php require "footer.php"; ?>