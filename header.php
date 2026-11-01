<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= isset($judul) ? e($judul) : "Cinemora" ?>
    </title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="navbar">

    <a href="index.php" class="logo">
        Cinemora
    </a>

    <nav>
        <a href="index.php">Beranda</a>
        <a href="film.php">Film</a>

        <?php if (isset($_SESSION["user"])): ?>
            <?php if ($_SESSION["user"]["role"] === "user"): ?>
                <a href="tiket.php">Tiket Saya</a>
            <?php endif; ?>
        <?php endif; ?>
    </nav>

    <div class="nav-actions">

        <?php if (isset($_SESSION["user"])): ?>

            <?php if ($_SESSION["user"]["role"] === "admin"): ?>
                <a href="admin.php" class="btn btn-dark">Admin</a>
            <?php endif; ?>

            <a href="keluar.php" class="btn btn-dark">Keluar</a>

        <?php else: ?>

            <a href="masuk.php" class="btn btn-dark">Masuk</a>
            <a href="daftar.php" class="btn">Daftar</a>

        <?php endif; ?>

    </div>

</header>

<main class="container">