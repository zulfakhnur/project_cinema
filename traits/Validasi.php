<?php

trait Validasi {

    public function wajibDiisi($data, $label = 'Data') {

        if (trim((string)$data) === '') {
            throw new Exception(
                $label . ' wajib diisi.'
            );
        }

    }

    public function emailValid($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format email tidak valid.");
        }
    }

}
