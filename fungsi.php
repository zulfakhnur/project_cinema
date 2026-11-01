<?php
session_start();

require_once "traits/FormatRupiah.php";
require_once "traits/Validasi.php";
require_once "classes/Database.php";
require_once "classes/Film.php";
require_once "classes/User.php";
require_once "classes/Timetable.php";
require_once "classes/Booking.php";

$pdo = (new Database())->koneksi();
$modelFilm = new Film($pdo);
$modelUser = new User($pdo);
$modelJadwal = new Timetable($pdo);
$modelBooking = new Booking($pdo);

function e($teks) {
    return htmlspecialchars(
        (string)$teks,
        ENT_QUOTES,
        "UTF-8"
    );
}

function wajibLogin() {

    if (!isset($_SESSION["user"])) {
        header("Location: masuk.php");
        exit;
    }

}

function wajibAdmin() {

    if (
        !isset($_SESSION["user"]) ||
        $_SESSION["user"]["role"] !== "admin"
    ) {
        header("Location: masuk.php");
        exit;
    }

}
?>