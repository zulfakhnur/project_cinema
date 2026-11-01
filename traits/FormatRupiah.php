<?php
trait FormatRupiah {

    public function rupiah($angka) {
        return 'Rp ' . number_format(
            (float)$angka,
            0,
            ',',
            '.'
        );
    }

}
