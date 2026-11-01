<?php
class Film {

    use Validasi;

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    private function kolom() {
        return "id AS id_film, title AS judul, genre, duration AS durasi,
                age_rating AS rating, synopsis AS sinopsis,
                poster AS warna, status";
    }

    public function semua($genre = "", $status = "") {
        $sql = "SELECT " . $this->kolom() . " FROM films WHERE 1=1";
        $params = [];

        if ($genre !== "") {
            $sql .= " AND genre = ?";
            $params[] = $genre;
        }
        if ($status !== "") {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $stmt = $this->db->prepare($sql . " ORDER BY id DESC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function cari($id) {
        $stmt = $this->db->prepare(
            "SELECT " . $this->kolom() . " FROM films WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function daftarGenre() {
        return $this->db->query(
            "SELECT DISTINCT genre FROM films ORDER BY genre"
        )->fetchAll();
    }

    public function tambah($d) {
        $this->cek($d);
        $stmt = $this->db->prepare(
            "INSERT INTO films (title, genre, duration, age_rating, synopsis, poster, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$d["judul"], $d["genre"], $d["durasi"], $d["rating"],
                        $d["sinopsis"], $d["poster"],
                        $d["status"] ?? "now_showing"]);
    }

    public function ubah($id, $d) {
        $this->cek($d);
        $stmt = $this->db->prepare(
            "UPDATE films SET title=?, genre=?, duration=?, age_rating=?,
            synopsis=?, poster=?, status=? WHERE id=?"
        );
        $stmt->execute([$d["judul"], $d["genre"], $d["durasi"], $d["rating"],
                        $d["sinopsis"], $d["poster"],
                        $d["status"] ?? "now_showing", $id]);
    }

    public function hapus($id) {
        $stmt = $this->db->prepare("DELETE FROM films WHERE id = ?");
        $stmt->execute([$id]);
    }

    private function cek($d) {
        $this->wajibDiisi($d["judul"], "Judul");
        $this->wajibDiisi($d["genre"], "Genre");
        $this->wajibDiisi($d["sinopsis"], "Sinopsis");

        if ((int)$d["durasi"] < 1) {
            throw new Exception("Durasi harus lebih dari 0.");
        }
    }

    public function unggahPoster($file) {
        if ($file["error"] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload poster gagal.");
        }

        if ($file["size"] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran poster maksimal 2 MB.");
        }

        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!in_array($ext, ["jpg", "jpeg", "png", "webp"])) {
            throw new Exception("Poster harus berformat JPG, PNG, atau WEBP.");
        }

        $nama = uniqid("poster_") . "." . $ext;
        move_uploaded_file($file["tmp_name"], __DIR__ . "/../img/" . $nama);
        return $nama;
    }
}
?>