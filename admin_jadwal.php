<?php
require_once "fungsi.php";

wajibAdmin();

$pesan = "";
$edit = null;

if (isset($_GET["hapus"])) {
    $modelJadwal->hapus((int)$_GET["hapus"]);
    header("Location: admin_jadwal.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id_jadwal"] ?? 0);

    $data = [
        "id_film"   => (int)($_POST["id_film"] ?? 0),
        "id_studio" => (int)($_POST["id_studio"] ?? 0),
        "tanggal"   => trim($_POST["tanggal"] ?? ""),
        "jam"       => trim($_POST["jam"] ?? ""),
        "harga"     => (int)($_POST["harga"] ?? 0)
    ];

    try {
        if ($id > 0) {
            $modelJadwal->ubah($id, $data);
        } else {
            $modelJadwal->tambah($data);
        }
        header("Location: admin_jadwal.php");
        exit;
    } catch (Exception $e) {
        $pesan = $e->getMessage();
    }
}

if (isset($_GET["edit"])) {
    $edit = $modelJadwal->cari((int)$_GET["edit"]);
}

$jadwals = $modelJadwal->semua();
$films   = $modelFilm->semua();
$studios = $modelJadwal->daftarStudio();

$judul = "Admin - Kelola Jadwal";

require "header.php";
?>

<div class="admin-layout">

    <aside class="admin-sidebar">

        <h3>BioskopKu Admin</h3>

        <a href="admin.php">Kelola Film</a>
        <a href="admin_jadwal.php" class="selected">Kelola Jadwal</a>
        <a href="tiket.php">Data Pemesanan</a>
        <a href="keluar.php">Keluar</a>

    </aside>

    <section class="admin-content">

        <div class="section-heading">
            <h1>Kelola Jadwal</h1>
            <a href="admin_jadwal.php" class="btn">Tambah Jadwal</a>
        </div>

        <?php if ($pesan): ?>
            <p class="alert"><?= e($pesan) ?></p>
        <?php endif; ?>
        
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Film</th>
                        <th>Studio</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($jadwals as $i => $j): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($j["judul"]) ?></td>
                            <td><?= e($j["studio"]) ?></td>
                            <td><?= date("d M Y", strtotime($j["tanggal"])) ?></td>
                            <td><?= e($j["jam"]) ?></td>
                            <td><?= $modelJadwal->rupiah($j["harga"]) ?></td>
                            <td class="actions">
                                <a href="admin_jadwal.php?edit=<?= $j["id_jadwal"] ?>"
                                    class="btn btn-small btn-dark">Edit</a>
                                <a href="admin_jadwal.php?hapus=<?= $j["id_jadwal"] ?>"
                                    class="btn btn-small"
                                    onclick="return confirm('Hapus jadwal ini? Pesanan di jadwal ini ikut terhapus.')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        
        <div class="form-panel">

            <h2><?= $edit ? "Edit Jadwal" : "Tambah Jadwal" ?></h2>

            <form method="POST" class="admin-form">

                <input type="hidden" name="id_jadwal"
                       value="<?= $edit["id_jadwal"] ?? 0 ?>">

                <label>Film</label>
                <select name="id_film">
                    <?php foreach ($films as $f): ?>
                        <option value="<?= $f["id_film"] ?>"
                            <?= ($edit["id_film"] ?? 0) == $f["id_film"] ? "selected" : "" ?>>
                            <?= e($f["judul"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Studio</label>
                <select name="id_studio">
                    <?php foreach ($studios as $s): ?>
                        <option value="<?= $s["id_studio"] ?>"
                            <?= ($edit["id_studio"] ?? 0) == $s["id_studio"] ? "selected" : "" ?>>
                            <?= e($s["nama"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Tanggal</label>
                <input type="date" name="tanggal"
                    value="<?= e($edit["tanggal"] ?? "") ?>" required>

                <label>Jam</label>
                <input type="time" name="jam"
                    value="<?= e($edit["jam"] ?? "") ?>" required>

                <label>Harga</label>
                <input type="number" name="harga" min="1000" step="1000"
                    value="<?= e($edit["harga"] ?? 45000) ?>" required>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan</button>
                    <a href="admin_jadwal.php" class="btn btn-dark">Batal</a>
                </div>

            </form>

        </div>

    </section>

</div>

<?php require "footer.php"; ?>