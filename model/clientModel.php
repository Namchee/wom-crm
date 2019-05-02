<?php
    class Client {
        private $id;
        private $nama;
        private $statusKawin;
        private $tanggalLahir;
        private $nilaiInvest;
        private $kota;
        private $gender;
        private $gambar;
        private $cs;
        private $age;

        public function _construct ($id, $nama, $statusKawin, $tanggalLahir, $nilaiInvest, $kota, $gender, $gambar, $cs, $age) {
            $this->id = $id;
            $this->nama = $nama;
            $this->statusKawin = $statusKawin;
            $this->tanggalLahir = $tanggalLahir;
            $this->nilaiInvest = $nilaiInvest;
            $this->kota = $kota;
            $this->gender = $gender;
            $this->gambar = $gambar;
            $this->cs = $cs;
            $this->age = $age;
        }
    }
?>