<?php
    class Region {
        public $id;
        public $nama;

        public function __construct($id, $nama) {
            $this->id = $id;
            $this->nama = $nama;
        }
    }
?>