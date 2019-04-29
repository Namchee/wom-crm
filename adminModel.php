<?php
    require_once "mysqlDB.php";
    class adminModel{

        private function cekKota($namakot){
            $query = "SELECT idK FROM kota wHERE namaKota = $namakot";
            $res = $db->executeSelectQuery($query);
            if($res){
                return true;
            }
            else{
                return false;
            }
        }
        private function getIdKota($namakot){
            $query = "SELECT idK FROM kota wHERE namaKota = $namakot";
            $res = $db->executeSelectQuery($query);
            return $res[0];
        }

        private function cekRegion($namareg){
            $query = "SELECT idR FROM region wHERE namaRegion = $namareg";
            $res = $db->executeSelectQuery($query);
            if($res){
                return true;
            }
            else{
                return false;
            }
        }

        private function getIdReg($namareg){
            $query = "SELECT idR FROM region wHERE namaRegion = $namareg";
            $res = $db->executeSelectQuery($query);
            return $res[0];
        }

        public function addKota(){
            $masuk = json_decode(file_get_contents('php://input'));
            $arrReg = $masuk->namareg;
            $arrLength = count($arrReg);
            $namakota = $masuk->namaKota;
            $namakota = $db->escapeString($namakota);
            if(cekKota($namakota)){
                $myObj->data = NULL;
                $myObj->pesan = "kota sudah ada";
                $myObj->status = false;
                echo json_encode($myObj);
            }
            else{
                $queries = "INSERT INTO kota VALUES (NULL, '$namakota')";
                $db->executeNonSelectQuery($queries);
                $myObj->data = $namakota;
                $myObj->pesan = "Berhasil Ditambah";
                $myObj->status = true;
                $idkot = getIdKota($namakota);
                for ($i=0; $i < $arrLength; $i++) { 
                        if(cekRegion($arrReg[$i])){
                            $idReg = getIdReg($arrReg[$i]);
                            $quer = "INSERT terdapatdi VALUES ('$idkot','$idReg')";
                            $db->executeNonSelectQuery($quer);
                        }
                        else{
                            $myObj->pesan = "Id tidak ada";
                        }
                }
                echo json_encode($myObj);
            }
        }
        
        public function addRegion(){
            $masuk = json_decode(file_get_contents('php://input'));
            $arrKot = $masuk->namakot;
            $arrLength = count($arrKot);
            $namareg = $masuk->namaRegion;
            $namareg = $db->escapeString($namareg);
            if(cekRegion($namareg)){
                $myObj->data = NULL;
                $myObj->pesan = "Region sudah ada";
                $myObj->status = false;
                echo json_encode($myObj);
            }
            else{
                $queries = "INSERT INTO region VALUES (NULL, '$namareg')";
                $db->executeNonSelectQuery($queries);
                $myObj->data = $namareg;
                $myObj->pesan = "Berhasil Ditambah";
                $myObj->status = true;
                $idreg = getIdReg($namareg);
                for ($i=0; $i < $arrLength; $i++) { 
                        if(cekKota($arrKot[$i])){
                            $idKot = getIdKota($arrKot[$i]);
                            $quer = "INSERT terdapatdi VALUES ('$idKot','$idReg')";
                            $db->executeNonSelectQuery($quer);
                        }
                        else{
                            $myObj->pesan = "Id tidak ada";
                        }
                }
                echo json_encode($myObj);
            }
        }
        
        public function addCS(){
            $masuk = json_decode(file_get_contents('php://input'));
            $username = $masuk->username;
            $password = $masuk->password;
            $nama = $masuk->nama;
            $query = "INSERT INTO users VALUES (NULL,'CURDATE()','$username','$password','$nama','0','1')";
            $db->executeNonSelectQuery($query);
            $myObj->username = $masuk->username;
            $myObj->pesan = "Customer Service berhasil ditambah";
            echo json_encode($myObj);
        }

        public function changeCSCLient(){
            $masuk = json_decode(file_get_contents('php://input'));
            $query = "SELECT idU FROM users";
            $idCSGanti = $masuk->idULama;
            $idCSBaru = $masuk->idUBaru;
            $query .= " WHERE idU = $idCSGanti";
            $result = $db->executeSelectQuery($query);
            $queries = "SELECT idU FROM users WHERE idU=$idCSBaru";
            $res = $db->executeSelectQuery($queries);
            if($result != NULL && $res != NULL){
                $quer = "UPDATE users SET idU = $idCSBaru WHERE idU=$idCSGanti";
                $db->executeNonSelectQuery($quer);
                $queri = "UPDATE users SET active = 0 WHERE idU=$idCSGanti";
                $db->executeNonSelectQuery($queri);
                $myObj->pesan = "Berhasil diubah";
                $myObj->status = true;
                echo json_encode($myObj);
            }
            else{
                $myObj->pesan = "Gagal diubah";
                $myObj->status = false;
                echo json_encode($myObj);
            }

        }

        public function changeCSInfo(){
            $masuk = json_decode(file_get_contents('php://input'));
            $query = "SELECT idU FROM users";
            $idCS = $masuk->idU;
            $query .= " WHERE idU = $idCS";
            $result = $db->executeSelectQuery($query);
            if($result != NULL){
                $username = $masuk->username;
                $password = $masuk->password;
                $nama = $masuk->nama;
                $quri = "UPDATE users SET username = $username, password=$password, nama=$nama";
                $db->executeNonSelectQuery($quri);
                $myObj->idU = $masuk->idU;
                $myObj->pesan = "Customer Service berhasil diubah";
                echo json_encode($myObj);
            }
            else{
                $myObj->idU = $masuk->idU;
                $myObj->pesan ="Customer Servie gagal diubah";
                echo json_encode($myObj);
            }
        }

        public function changeCityReg(){
            $masuk = json_decode(file_get_contents('php://input'));
            $idK = $masuk->idK;
            $idR = $masuk->idR;
            $quer = "SELECT idK FROM terdapatdi WHERE idK = $idK";
            $res = $db->executeSelectQuery($quer);
            $quers = "SELECT idR FROM region WHERE idR = $idR";
            $resu = $db->executeSelectQuery($quers);
            if($res != NULL && $resu!=NULL){
                $queri = "UPDATE terdapatdi SET idR = $idR";
                $db->executeNonSelectQuery($queri);
                $myObj->idK = $masuk->idK;
                $myObj->pesan ="Daftar Kota berhasil diubah";
                echo json_encode($myObj);
            }
            else{
                $myObj->idK = $masuk->idK;
                $myObj->pesan ="Daftar Kota gagal diubah";
                echo json_encode($myObj);
            }
        }
    }
?>
