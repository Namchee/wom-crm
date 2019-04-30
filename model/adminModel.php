<?php
    require_once "mysqlDB.php";
    class adminModel{
        public function cekKota($namakot){
            $query = "SELECT idK FROM kota wHERE namaKota = '$namakot'";
            $res = $db->executeSelectQuery($query);
            if($res){
                return true;
            }
            else{
                return false;
            }
        }
        private function getIdKota($namakot){
            $query = "SELECT idK FROM kota wHERE namaKota = '$namakot'";
            $res = $db->executeSelectQuery($query);
            return $res[0];
        }
        public function cekRegion($namareg){
            $query = "SELECT idR FROM region wHERE namaRegion = '$namareg'";
            $res = $db->executeSelectQuery($query);
            if($res){
                return true;
            }
            else{
                return false;
            }
        }
        private function getIdReg($namareg){
            $query = "SELECT idR FROM region wHERE namaRegion = '$namareg'";
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
                            $quer = "INSERT INTO terdapatdi VALUES ($idkot,$idReg)";
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
                            $quer = "INSERT INTO terdapatdi VALUES ($idKot,$idReg)";
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
            $query = "INSERT INTO users VALUES (NULL,'CURDATE()','$username','$password','$nama',0,1)";
            $db->executeNonSelectQuery($query);
            $myObj->username = $masuk->username;
            $myObj->pesan = "Customer Service berhasil ditambah";
            echo json_encode($myObj);
        }
        
        public function changeCSCLient(){
            $masuk = json_decode(file_get_contents('php://input'));
            $idClient = $masuk->idClient;
            $idCS = $masuk->idCS;
            $query = "SELECT idC FROM client WHERE idC=$idClient";
            $res = $db->executeSelectQuery($query);
            $que = "SELECT idU FROM users WHERE idU = $idCS";
            $result = $db->executeSelectQuery($que);
            if($res[0]!=null&&$result[0]!=null){
                $ques = "UPDATE client SET idU=$idCS WHERE idC=$idClient";
                $db->executeNonSelectQuery($ques);
                $myObj->data = $idClient;
                $myObj->pesan = "Client berhasil di ubah";
                $myObj->status = true;
                echo json_encode($myObj);
            }else{
                $myObj->data = $idClient;
                $myObj->pesan = "Client gagal di ubah";
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
                $quri = "UPDATE users SET username = '$username', password='$password', nama='$nama'";
                $db->executeNonSelectQuery($quri);
                $myObj->idU = $masuk->idU;
                $myObj->pesan = "Customer Service berhasil diubah";
                echo json_encode($myObj);
            }
            else{
                $myObj->idU = $masuk->idU;
                $myObj->pesan ="Customer Service gagal diubah";
                echo json_encode($myObj);
            }
        }
        
        public function changeCityReg(){
            $masuk = json_decode(file_get_contents('php://input'));
            $arrKota = $masuk->idK;
            $region = $masuk->idR;
            $query = "DELETE FROM terdapatdi WHERE idR=$region";
            $db->executeNonSelectQuery($query);
            foreach($arrKota as $value){
                $que = "INSERT INTO terdapatdi (idK,idR) VALUES ($value,$region)";
                $db->executeNonSelectQuery($que);
            }
        }
    }
?>
