<?php
class Timetable {

        use FormatRupiah, Validasi;

    private $db;
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function milikFilm($idFilm) {
        $stmt = $this->db->prepare(
            "SELECT t.id AS id_jadwal,
                    t.show_date AS tanggal,
                    TIME_FORMAT(t.show_time, '%H:%i') AS jam,
                    t.price AS harga,
                    s.name AS studio
            FROM timetables t
            JOIN studios s ON t.studio_id = s.id
            WHERE t.film_id = ? AND t.show_date >= CURDATE()
            ORDER BY t.show_date, t.show_time"
        );
        $stmt->execute([$idFilm]);
        return $stmt->fetchAll();
    }

    public function cari($id) {
        $stmt = $this->db->prepare(
            "SELECT t.id AS id_jadwal,
                    t.studio_id AS id_studio,
                    t.film_id AS id_film,
                    f.title AS judul,
                    s.name AS studio,
                    t.show_date AS tanggal,
                    TIME_FORMAT(t.show_time, '%H:%i') AS jam,
                    t.price AS harga
            FROM timetables t
            JOIN films f ON t.film_id = f.id
            JOIN studios s ON t.studio_id = s.id
            WHERE t.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function semua() {
        return $this->db->query(
            "SELECT t.id AS id_jadwal,
                    f.title AS judul,
                    s.name AS studio,
                    t.show_date AS tanggal,
                    TIME_FORMAT(t.show_time, '%H:%i') AS jam,
                    t.price AS harga
            FROM timetables t
            JOIN films f ON t.film_id = f.id
            JOIN studios s ON t.studio_id = s.id
            ORDER BY t.show_date, t.show_time"
        )->fetchAll();
    }

    public function daftarStudio() {
        return $this->db->query(
            "SELECT id AS id_studio, name AS nama FROM studios ORDER BY name"
        )->fetchAll();
    }

    public function tambah($d) {
        $this->cek($d);
        $stmt = $this->db->prepare(
            "INSERT INTO timetables (film_id, studio_id, show_date, show_time, price)
            VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$d["id_film"], $d["id_studio"],
                        $d["tanggal"], $d["jam"], $d["harga"]]);
    }

    public function ubah($id, $d) {
        $this->cek($d, $id);
        $stmt = $this->db->prepare(
            "UPDATE timetables
            SET film_id=?, studio_id=?, show_date=?, show_time=?, price=?
            WHERE id=?"
        );
        $stmt->execute([$d["id_film"], $d["id_studio"],
                        $d["tanggal"], $d["jam"], $d["harga"], $id]);
    }

    public function hapus($id) {
        $stmt = $this->db->prepare("DELETE FROM timetables WHERE id = ?");
        $stmt->execute([$id]);
    }

    private function cek($d, $id = 0) {
        if ((int)$d["id_film"] < 1) {
            throw new Exception("Pilih film.");
        }
        if ((int)$d["id_studio"] < 1) {
            throw new Exception("Pilih studio.");
        }
        $this->wajibDiisi($d["tanggal"], "Tanggal");
        $this->wajibDiisi($d["jam"], "Jam");

        if ((int)$d["harga"] < 1) {
            throw new Exception("Harga harus lebih dari 0.");
        }

        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM timetables
            WHERE studio_id = ? AND show_date = ? AND show_time = ? AND id <> ?"
        );
        $stmt->execute([$d["id_studio"], $d["tanggal"], $d["jam"], $id]);

        if ($stmt->fetchColumn() > 0) {
            throw new Exception("Studio itu sudah punya jadwal di tanggal dan jam yang sama.");
        }
    }
}