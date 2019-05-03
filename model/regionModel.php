<?php
    class Region {
        public $id;
        public $nama;
        public $jumlah;

        public function __construct($id, $nama, $jumlah) {
            $this->id = $id;
            $this->nama = $nama;
            $this->jumlah = $jumlah;
        }
    }
?>