<?php
require_once "fungsi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        $modelUser->daftar(
            trim($_POST["nama"] ?? ""),
            trim($_POST["email"] ?? ""),
            $_POST["password"] ?? ""
        );
        header("Location: masuk.php");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$judul = "Daftar - BioskopKu";

require "header.php";
?>

<section class="auth-card">

    <h2>Daftar</h2>

    <?php if ($error): ?>
        <p class="alert"><?= e($error) ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Nama</label>

        <input type="text"
            name="nama"
            required>

        <label>Email</label>

        <input type="email"
            name="email"
            required>

        <label>Password</label>

        <input type="password"
            name="password"
            minlength="6"
            required>

        <button type="submit" class="btn btn-block">
            Daftar
        </button>

    </form>

    <p class="auth-foot">
        Sudah punya akun?
        <a href="masuk.php">Masuk</a>
    </p>

</section>

<?php require "footer.php"; ?>