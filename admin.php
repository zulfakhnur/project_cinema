<?php
require_once "fungsi.php";

wajibAdmin();

$pesan = "";
$edit = null;

if (isset($_GET["hapus"])) {
    $modelFilm->hapus((int)$_GET["hapus"]);
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id_film"] ?? 0);
    $poster = $_POST["poster_lama"] ?? "poster-red";

    try {
        if (!empty($_FILES["poster_file"]["name"])) {
            $poster = $modelFilm->unggahPoster($_FILES["poster_file"]);
        }

        $data = [
            "judul"    => trim($_POST["judul"]),
            "genre"    => trim($_POST["genre"]),
            "durasi"   => (int)$_POST["durasi"],
            "rating"   => trim($_POST["rating"]),
            "sinopsis" => trim($_POST["sinopsis"]),
            "poster"   => $poster,
            "status"   => $_POST["status"] ?? "now_showing"
        ];

        if ($id > 0) {
            $modelFilm->ubah($id, $data);
        } else {
            $modelFilm->tambah($data);
        }
        header("Location: admin.php");
        exit;
    } catch (Exception $e) {
        $pesan = $e->getMessage();
    }
}

if (isset($_GET["edit"])) {
    $edit = $modelFilm->cari((int)$_GET["edit"]);
}

$films = $modelFilm->semua();
$judul = "Admin - Kelola Film";

require "header.php";
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <h3>BioskopKu Admin</h3>

        <a href="admin.php" class="selected">
            Kelola Film
        </a>

        <a href="admin_jadwal.php">
            Kelola Jadwal
        </a>

        <a href="admin_pemesanan.php">Data Pemesanan</a>

        <a href="keluar.php">
            Keluar
        </a>
    </aside>

    <section class="admin-content">
        <div class="section-heading">
            <h1>Kelola Film</h1>
            <a href="admin.php" class="btn">
                Tambah Film
            </a>
        </div>

        <?php if ($pesan): ?>
            <p class="alert"><?= e($pesan) ?></p>
        <?php endif; ?>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Genre</th>
                        <th>Durasi</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($films as $i => $f): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($f["judul"]) ?></td>
                            <td><?= e($f["genre"]) ?></td>
                            <td><?= (int)$f["durasi"] ?> menit</td>
                            <td><?= e($f["rating"]) ?></td>
                            <td class="actions">
                                <a href="admin.php?edit=<?= $f["id_film"] ?>"
                                    class="btn btn-small btn-dark">
                                    Edit
                                </a>

                                <a href="admin.php?hapus=<?= $f["id_film"] ?>"
                                    class="btn btn-small"
                                    onclick="return confirm('Hapus film ini?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="form-panel">
            <h2>
                <?= $edit ? "Edit Film" : "Tambah Film" ?>
            </h2>

            <form method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="hidden"
                    name="id_film"
                    value="<?= $edit["id_film"] ?? 0 ?>">

                <label>Judul Film</label>
                <input type="text"
                    name="judul"
                    value="<?= e($edit["judul"] ?? "") ?>"
                    required>

                <label>Genre</label>
                <input type="text"
                    name="genre"
                    value="<?= e($edit["genre"] ?? "") ?>"
                    required>

                <label>Durasi</label>
                <input type="number"
                    name="durasi"
                    min="1"
                    value="<?= e($edit["durasi"] ?? 120) ?>"
                    required>

                <label>Rating</label>
                <input type="text"
                    name="rating"
                    value="<?= e($edit["rating"] ?? "13+") ?>"
                    required>

                <label>Sinopsis</label>
                <textarea name="sinopsis" rows="3" required><?= e($edit["sinopsis"] ?? "") ?></textarea>

                <label>Poster (JPG/PNG/WEBP, maks 2 MB)</label>
                <input type="file" name="poster_file" accept=".jpg,.jpeg,.png,.webp">
                <input type="hidden" name="poster_lama" value="<?= e($edit["warna"] ?? "poster-red") ?>">

                <label>Status</label>
                <select name="status">
                    <option value="now_showing" <?= ($edit["status"] ?? "now_showing") === "now_showing" ? "selected" : "" ?>>Sedang Tayang</option>
                    <option value="coming_soon" <?= ($edit["status"] ?? "") === "coming_soon" ? "selected" : "" ?>>Akan Datang</option>
                </select>

                <div class="form-actions">
                    <button type="submit" class="btn">
                        Simpan
                    </button>
                    <a href="admin.php" class="btn btn-dark">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>

<?php require "footer.php"; ?>