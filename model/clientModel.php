<?php
    class Client {
        public $id;
        public $nama;
        public $statusKawin;
        public $tanggalLahir;
        public $nilaiInvest;
        public $kota;
        public $gender;
        public $cs;
        public $age;

        public function __construct ($id, $nama, $statusKawin, $tanggalLahir, $nilaiInvest, $kota, $gender, $cs, $age) {
            $this->id = $id;
            $this->nama = $nama;
            $this->statusKawin = $statusKawin;
            $this->tanggalLahir = $tanggalLahir;
            $this->nilaiInvest = $nilaiInvest;
            $this->kota = $kota;
            $this->gender = $gender;
            $this->cs = $cs;
            $this->age = $age;
        }
    }
?>