<?php
    require_once "mysqlDB.php";
    require_once "userModel.php";
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
            $arrReg = $db->escapeString($arrReg);
            $namakota = $masuk->namaKota;
            $namakota = $db->escapeString($namakota);
            if(cekKota($namakota)){
                $myObj->data = NULL;
                $myObj->pesan = "kota sudah ada";
                $myObj->status = false;
                echo json_encode($myObj);
            }
            else{
                if(cekArrReg($arrReg)){
                    $queries = "INSERT INTO region VALUES (NULL, '$namareg')";
                    $db->executeNonSelectQuery($queries);
                    $myObj->data = $namakota;
                    $myObj->pesan = "Berhasil Ditambah";
                    $myObj->status = true;
                    $idkot = getIdKota($namakota);
                    foreach($arrReg as $value){
                        $idReg = getIdReg($value);
                        $que = "INSERT INTO terdapatdi VALUES ($idkot, $idReg)";
                        $db->executeNonSelectQuery($queries);
                    }
                    echo json_encode($myObj);
                }else{
                    $myObj->data = $namakota;
                    $myObj->pesan = "Tidak bisa ditambah";
                    $myObj->status = false;
                    echo json_encode($myObj);
                }
            }
        }
        
        
        
        public function addRegion(){
            $masuk = json_decode(file_get_contents('php://input'));
            $arrKot = $masuk->namakot;
            $arrKot = $db->escapeString($arrKot);
            escapeArray($arrKot);
            $namareg = $masuk->namaRegion;
            $namareg = $db->escapeString($namareg);
            if(cekRegion($namareg)){
                $myObj->data = NULL;
                $myObj->pesan = "Region sudah ada";
                $myObj->status = false;
                echo json_encode($myObj);
            }
            else{
                if(cekArrKota($arrKot)){
                    $queries = "INSERT INTO region VALUES (NULL, '$namareg')";
                    $db->executeNonSelectQuery($queries);
                    $myObj->data = $namareg;
                    $myObj->pesan = "Berhasil Ditambah";
                    $myObj->status = true;
                    $idkot = getIdRegion($namareg);
                    foreach($arrKot as $value){
                        $idKot = getIdKota($value);
                        $que = "INSERT INTO terdapatdi VALUES ($idkot, $idReg)";
                        $db->executeNonSelectQuery($queries);
                    }
                    echo json_encode($myObj);
                }else{
                    $myObj->data = $namareg;
                    $myObj->pesan = "Tidak bisa ditambah";
                    $myObj->status = false;
                    echo json_encode($myObj);
                }
            }
        }
        
        private function getIdCS($nama){
            $query = "SELECT idU FROM users WHERE username = '$nama'";
            $res = $db->executeSelectQuery($query);
            return $res[0];
        }
        
        private function cekCS($nama){
            $query = "SELECT idU FROM kota wHERE username = '$nama'";
            $res = $db->executeSelectQuery($query);
            if($res){
                return true;
            }else{
                return false;
            }
        }
        
        public function addCS(){
            $masuk = json_decode(file_get_contents('php://input'));
            $username = $masuk->username;
            $username = $db->escapeString($username);
            $password = $masuk->password;
            $password = $db->escapeString($password);
            $arrEmail = $masuk->email;
            escapeArray($arrEmail);
            if(cekCS($username)){
                $myObj->username = $masuk->username;
                $myObj->pesan = "Customer Service gagal ditambah";
                $myObj->status = false;
                echo json_encode($myObj);
            }else{
                $query = "INSERT INTO users VALUES (NULL,'CURDATE()','$username','$password','$nama',0,1)";
                $db->executeNonSelectQuery($query);
                $id = getIdCS($nama);
                foreach($arrEmail as $value){
                    $que = "INSERT INTO kontak VALUES ($id,'$value')";
                    $db->executeNonSelectQuery($que);
                }
                $myObj->username = $masuk->username;
                $myObj->pesan = "Customer Service berhasil ditambah";
                echo json_encode($myObj);
            }
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
                $username = $db->escapeString($username);
                $password = $masuk->password;
                $password = $db->escapeString($password);
                $nama = $masuk->nama;
                $nama = $db->escapeString($nama);
                $quri = "UPDATE users SET username = '$username', password='$password', nama='$nama'";
                $db->executeNonSelectQuery($quri);
                $myObj->idU = $masuk->idU;
                $myObj->pesan = "Customer Service berhasil diubah";
                $myObj->status=true;
                echo json_encode($myObj);
            }
            else{
                $myObj->idU = $masuk->idU;
                $myObj->pesan ="Customer Service gagal diubah";
                $myObj->status=false;
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
        
        public function deleteRegion(){
            $masuk = json_decode(file_get_contents('php://input'));
            $reg = $masuk->namaRegion;
            $reg = $db->escapeString($reg);
            if(cekRegion($reg)){
                $idReg = getIdReg($reg);
                $query = "DELETE FROM region WHERE namaRegion='$reg'";
                $db->executeNonSelectQuery($query);
                $que = "DELETE FROM terdapatdi WHERE idR=$idReg";
                $db->executeNonSelectQuery($que);
                $myObj->data = '$reg';
                $myObj->pesan ="Region berhasil dihapus";
                $myObj->status = true;
                echo json_encode($myObj);
            }else{
                $myObj->data = '$reg';
                $myObj->pesan ="Region gagal dihapus";
                $myObj->status = false;
                echo json_encode($myObj);
            }
        }
        
        public function deleteKota(){
            $masuk = json_decode(file_get_contents('php://input'));
            $kota = $masuk->namaKota;
            $kota = $db->escapeString($kota);
            if(cekKota($kota)){
                $idKot = getIdKota($kota);
                $query = "DELETE FROM kota WHERE namaKota='$kota'";
                $db->executeNonSelectQuery($query);
                $que = "DELETE FROM terdapatdi WHERE idK=$idKot";
                $db->executeNonSelectQuery($que);
                $myObj->data = '$kota';
                $myObj->pesan ="Kota berhasil dihapus";
                $myObj->status = true;
                echo json_encode($myObj);
            }else{
                $myObj->data = '$kota';
                $myObj->pesan ="Kota gagal dihapus";
                $myObj->status = false;
                echo json_encode($myObj);
            }
        }
        
        public function aktifkanCS(){
            $masuk = json_decode(file_get_contents('php://input'));
            $user = $masuk->username;
            $user = $db->escapeString($user);
            if(cekCS($user)){
                if(userModel::cekActive($user)){
                    $myObj->data = '$user';
                    $myObj->pesan ="CS gagal diaktifkan";
                    $myObj->status = false;
                    echo json_encode($myObj);
                }else{
                    $query="UPDATE users SET active=1 WHERE username='$user'";
                    $db->executeNonSelectQuery($query);
                    $myObj->data = '$user';
                    $myObj->pesan ="CS berhasil diaktifkan";
                    $myObj->status = true;
                    echo json_encode($myObj);
                }
            }else{
                $myObj->data = null;
                $myObj->pesan ="CS tidak ada";
                $myObj->status = false;
                echo json_encode($myObj);
            }
        }
        private function cekRegId($id){
            $query = "SELECT idR from region WHERE idR=$id";
            $res=$db-executeSelectQuery($query);
            if($res){
                return true;
            }else{
                return false;
            }
        }
        public function getKotaRegion(){
            $masuk = json_decode(file_get_contents('php://input'));
            $region = $masuk->idR;
            if(cekRegId($region)){
                $query = "SELECT kota.idK as 'ID Kota',kota.namaKota as 'Nama Kota' FROM region INNER JOIN terdapatdi ON region.idR=terdapatdi.idR
                INNER JOIN kota ON terdapatdi.idK=kota.idK WHERE region.idR='$region'";
                $res=$db->executeSelectQuery($query);
                echo json_encode($res);
            }else{
                $myObj->pesan = "Region tidak ada";
                $myObj->status = false;
                echo json_encode($myObj);
            }
        }
        
        public function escapeArray($array){
            foreach($array as $value){
                $value = $db->escapeString($value);
            }
        }
        
        private function cekArrKota($array){
            $status=false;
            foreach($array as $value){
                if(cekKota($value)){
                    $status=true;
                }else{
                    $status=false;
                }
            }
            return $status;
        }
        private function cekArrReg($array){
            $status=false;
            foreach($array as $value){
                if(cekRegion($value)){
                    $status=true;
                }else{
                    $status=false;
                }
            }
            return $status;
        }
    }
?>
