<?php
require_once "fungsi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $modelUser->login(
        trim($_POST["email"] ?? ""),
        $_POST["password"] ?? ""
    );

    if ($user) {
        $_SESSION["user"] = $user;
        header("Location: " . ($user["role"] === "admin" ? "admin.php" : "index.php"));
        exit;
    }

    $error = "Email atau password salah.";
}

$judul = "Masuk - BioskopKu";

require "header.php";
?>

<section class="auth-card">

    <h2>Masuk</h2>

    <?php if ($error): ?>
        <p class="alert"><?= e($error) ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Email</label>

        <input type="email"
            name="email"
            required>

        <label>Password</label>

        <input type="password"
            name="password"
            required>

        <button type="submit" class="btn btn-block">
            Masuk
        </button>

    </form>

    <p class="auth-foot">
        Belum punya akun?
        <a href="daftar.php">Daftar</a>
    </p>

</section>

<?php require "footer.php"; ?>