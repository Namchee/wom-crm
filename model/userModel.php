<?php
    class User {
        public $id;
        public $username;
        public $name;
        public $tanggalGabung;

        public function __construct($id, $name, $username, $tanggalGabung) {
            $this->id = $id;
            $this->username = $username;
            $this->name = $name;
            $tanggal = date_create($tanggalGabung);
            $this->tanggalGabung = date_format($tanggal, "d-m-Y");
        }
    }
?>