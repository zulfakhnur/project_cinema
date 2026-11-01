<?php
class Booking {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function kursiTerisi($idJadwal) {
        $stmt = $this->db->prepare(
            "SELECT s.seat_code
            FROM booking_details d
            JOIN seats s ON d.seat_id = s.id
            WHERE d.timetable_id = ?"
        );
        $stmt->execute([$idJadwal]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function pesan($idUser, $jadwal, $kodeKursi) {

        if (!$kodeKursi) {
            throw new Exception("Pilih minimal satu kursi.");
        }

        if (array_intersect($kodeKursi, $this->kursiTerisi($jadwal["id_jadwal"]))) {
            throw new Exception("Kursi sudah dipesan. Silakan pilih kursi lain.");
        }
        $this->db->beginTransaction();
        try {
            $tanda = implode(",", array_fill(0, count($kodeKursi), "?"));

            $stmt = $this->db->prepare(
                "SELECT id FROM seats
                WHERE studio_id = ? AND seat_code IN ($tanda)"
            );
            $stmt->execute(array_merge([$jadwal["id_studio"]], $kodeKursi));
            $idKursi = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (count($idKursi) !== count($kodeKursi)) {
                throw new Exception("Kursi tidak valid.");
            }
                        $kode  = "BK" . strtoupper(bin2hex(random_bytes(4)));
            $total = count($idKursi) * $jadwal["harga"];

            $stmt = $this->db->prepare(
                "INSERT INTO bookings
                (booking_code, user_id, timetable_id, total_price, status)
                VALUES (?, ?, ?, ?, 'paid')"
            );
            $stmt->execute([$kode, $idUser, $jadwal["id_jadwal"], $total]);
            $idBooking = $this->db->lastInsertId();

            $detail = $this->db->prepare(
                "INSERT INTO booking_details (booking_id, timetable_id, seat_id)
                VALUES (?, ?, ?)"
            );
            foreach ($idKursi as $k) {
                $detail->execute([$idBooking, $jadwal["id_jadwal"], $k]);
            }

            $this->db->commit();
                    } catch (PDOException $e) {
            $this->db->rollBack();
            if ($e->getCode() == 23000) {
                throw new Exception("Kursi sudah dipesan. Silakan pilih kursi lain.");
            }
            throw new Exception("Pemesanan gagal. Silakan coba kembali.");
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function milikUser($idUser) {
        $stmt = $this->db->prepare(
            "SELECT b.id AS id_pemesanan,
                    b.booking_code AS kode_booking,
                    b.total_price AS total,
                    CASE b.status
                        WHEN 'paid' THEN 'LUNAS'
                        WHEN 'cancelled' THEN 'BATAL'
                        ELSE 'PENDING'
                    END AS status,
                    f.title AS judul,
                    s.name AS studio,
                    t.show_date AS tanggal,
                    TIME_FORMAT(t.show_time, '%H:%i') AS jam,
                    GROUP_CONCAT(st.seat_code ORDER BY st.seat_code SEPARATOR ', ') AS kursi
            FROM bookings b
            JOIN timetables t ON b.timetable_id = t.id
            JOIN films f ON t.film_id = f.id
            JOIN studios s ON t.studio_id = s.id
            LEFT JOIN booking_details d ON d.booking_id = b.id
            LEFT JOIN seats st ON d.seat_id = st.id
            WHERE b.user_id = ?
            GROUP BY b.id
            ORDER BY b.id DESC"
        );
        $stmt->execute([$idUser]);
        return $stmt->fetchAll();
    }

    public function batal($idBooking, $idUser) {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare(
                "UPDATE bookings SET status = 'cancelled'
                WHERE id = ? AND user_id = ? AND status = 'paid'"
            );
            $stmt->execute([$idBooking, $idUser]);

            if ($stmt->rowCount() > 0) {
                $hapus = $this->db->prepare(
                    "DELETE FROM booking_details WHERE booking_id = ?"
                );
                $hapus->execute([$idBooking]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}