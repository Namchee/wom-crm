<?php
    require_once 'services/mysqldb.php';
    require_once 'model/userModel.php';
    require_once 'services/view.php';
    require_once 'controller/csController.php';
    require_once 'model/regionModel.php';
    require_once 'model/kotaModel.php';
    require_once 'model/clientModel.php';

    class AdminController {
        private $db;

        public function __construct() {
            $this->db = new MySQLDB("localhost", "root", "", "crm");
        }

        public function viewDashboard() {
            $result = $this->getCS();
            return View::render('admin_dashboard.php', [
                "result" => $result,
                "title" => "Dashboard - Wombat Inc. CRM"
            ]);
        }

        public function getCS() {
			$query = "SELECT idU, nama, tanggalGabung, username FROM users WHERE status = 0";
			$res = $this->db->executeSelectQuery($query);
            $cs = [];
            foreach ($res as $key=>$value) {
                $cs[] = new User($value["idU"], $value["nama"], $value['username'], $value['tanggalGabung']);
            }

            return $cs;
        }

        public function getCSById() {
			$id = $_GET['id'];
            $id = $this->db->escapeString($id);
            $query = "SELECT idU, nama, tanggalGabung, username FROM users WHERE status = 0 AND idU = $id";
            $result = ($this->db->executeSelectQuery($query))[0];
            $json = (object)array();
            $json->idU = $result['idU'];
            $json->nama = $result['nama'];
            $json->tanggalGabung = $result['tanggalGabung'];
            $json->username = $result['username'];
            return json_encode($json);
        }

        public function viewAddCS() {
            return View::render('static/add_cs.html', [
                "title" => "Tambah Customer Service - Wombat Inc. CRM"
            ]);
        }

        public function addCS() {
            $myObj = (object)array();
            $masuk = json_decode(file_get_contents('php://input'));
            $username = $masuk->username;
            $username = $this->db->escapeString($username);
            $password = $masuk->password;
            $password = $this->db->escapeString($password);
            $nama = $masuk->nama;
            $nama = $this->db->escapeString($nama);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $arrEmail = $masuk->email;
            $this->escapeArray($arrEmail);
            if ($this->cekNamaCS($username)) {
                $myObj->username = $masuk->username;
                $myObj->pesan = "Username Sudah Dipakai";
                $myObj->status = false;
                return json_encode($myObj);
            } else {
                $query = "INSERT INTO users VALUES ('$nama', CURDATE(), '$username', '$password', NULL, 0)";
                $this->db->executeNonSelectQuery($query);
                $id = $this->getIdCS($username);
                foreach ($arrEmail as $value) {
                    $que = "INSERT INTO kontak VALUES ($id, '$value')";
                    $this->db->executeNonSelectQuery($que);
                }
                $myObj->status = true;
                $myObj->username = $masuk->username;
                $myObj->pesan = "Customer Service berhasil ditambah";
                return json_encode($myObj);
            }
        } 

        private function escapeArray($array) {
            $escaped = [];
            foreach ($array as $value) {
                $escaped[] = $this->db->escapeString($value);
            }
            return $escaped;
        }

        private function cekNamaCS($nama) {
            $query = "SELECT idU FROM users wHERE username = '$nama'";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }

        private function getIdCS($nama) {
            $query = "SELECT idU FROM users WHERE username = '$nama'";
            $res = $this->db->executeSelectQuery($query);
            return $res[0]['idU'];
        }

        public function getClientCS() {
			$masuk = json_decode(file_get_contents('php://input'));
			$idClient = $this->db->escapeString($masuk->idC);
			if (cekIdClient($idClient)) {
				$query = "SELECT users.idU,users.nama FROM users INNER JOIN client on users.idU=client.idU
				WHERE client.idC=$idClient";
				$res = $this->db->executeSelectQuery($query);
				$myObj->idCS = $res[0]['idU'];
				$myObj->nama = $res[0]['nama'];
				$myObj->status = true;
				return json_encode($myObj);
			} else {
				$myObj->pesan = "Client tidak ada";
				$myObj->status = false;
				return json_encode($myObj);
			}
		}

        public function viewAddKota() {
            $regions = $this->getRegions();
            return View::render('add_kota.php', [
                "result" => $regions,
                "title" => "Add Kota - Wombat Inc. CRM"
            ]);
        }

        public function viewAddRegion() {
            $kotas = $this->getKotas();
            return View::render('add_region.php', [
                "result" => $kotas,
                "title" => "Add Region - Wombat Inc. CRM"
            ]);
        }

        private function getRegions() {
            $query = "SELECT * FROM viewRegion";
            $res = $this->db->executeSelectQuery($query);
            $regions = [];
            foreach ($res as $key=>$value) {
                $regions[] = new Region($value['idR'], $value['namaRegion'], $value['jumlah_kota']);
            }
            return $regions;
        }

        public function getRegionById() {
            $region = $this->db->escapeString($_GET['id']);
            if ($this->cekRegId($region)) {
                $query = "SELECT kota.idK FROM region INNER JOIN terdapatdi ON region.idR = terdapatdi.idR
                INNER JOIN kota ON terdapatdi.idK = kota.idK WHERE region.idR = '$region'";
                $res = $this->db->executeSelectQuery($query);
                return json_encode($res);
            } else {
                $myObj->pesan = "Region tidak ada";
                $myObj->status = false;
                return json_encode($myObj);
            }
        }
        
        private function cekRegId($id) {
            $query = "SELECT idR from region WHERE idR = $id";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }

        private function getKotas() {
            $query = "SELECT * FROM kota";
            $res = $this->db->executeSelectQuery($query);
            $kotas = [];
            foreach ($res as $key=>$value) {
                $kotas[] = new Kota($value['idK'], $value['namaKota']);
            }
            return $kotas;
        }

        public function addKota() {
            $myObj = (object)array();
            $masuk = json_decode(file_get_contents('php://input'));
            $arrReg = $masuk->namareg;
            $arrReg = $this->escapeArray($arrReg);
            $namakota = $masuk->namaKota;
            $namakota = $this->db->escapeString($namakota);
            if ($this->cekKota($namakota)) {
                $myObj->data = NULL;
                $myObj->pesan = "Kota sudah ada";
                $myObj->status = false;
                return json_encode($myObj);
            } else {
                if ($this->cekArrReg($arrReg)) {
                    $queries = "INSERT INTO kota VALUES (NULL, '$namakota')";
                    $this->db->executeNonSelectQuery($queries);
                    $myObj->data = $namakota;
                    $myObj->pesan = "Berhasil Ditambah";
                    $myObj->status = true;
                    $idkot = $this->getIdKota($namakota);
                    foreach ($arrReg as $key=>$value) {
                        $que = "INSERT INTO `terdapatdi` VALUES ('$idkot', '$value')";
                        $this->db->executeNonSelectQuery($que);
                    }
                    return json_encode($myObj);
                } else {
                    $myObj->data = $namakota;
                    $myObj->pesan = "Tidak bisa ditambah";
                    $myObj->status = false;
                    return json_encode($myObj);
                }
            }
        }

        public function addRegion() {
            $myObj = (object)array();
            $masuk = json_decode(file_get_contents('php://input'));
            $arrKot = $masuk->namakot;
            $arrKot = $this->escapeArray($arrKot);
            $namareg = $masuk->namaRegion;
            $namareg = $this->db->escapeString($namareg);
            if ($this->cekRegion($namareg)) {
                $myObj->data = NULL;
                $myObj->pesan = "Region sudah ada";
                $myObj->status = false;
                return json_encode($myObj);
            } else {
                if ($this->cekArrKota($arrKot)) {
                    $queries = "INSERT INTO region VALUES (NULL, '$namareg')";
                    $this->db->executeNonSelectQuery($queries);
                    $myObj->data = $namareg;
                    $myObj->pesan = "Berhasil Ditambah";
                    $myObj->status = true;
                    $idReg = $this->getIdRegion($namareg);
                    foreach ($arrKot as $key=>$value) {
                        $que = "INSERT INTO terdapatdi VALUES ('$value', '$idReg')";
                        $this->db->executeNonSelectQuery($que);
                    }
                    return json_encode($myObj);
                } else {
                    $myObj->data = $namareg;
                    $myObj->pesan = "Tidak bisa ditambah";
                    $myObj->status = false;
                    return json_encode($myObj);
                }
            }
        }

        public function changeCityReg() {
            $myObj = (object)array();
            $masuk = json_decode(file_get_contents('php://input'));
            $arrKota = $masuk->idK;
            $arrKota = $this->escapeArray($arrKota);
            if (count($arrKota) <= 0) {
                $myObj->status = false;
                $myObj->pesan = "Region tidak boleh kosong";
                return $myObj;
            }
            $region = $masuk->idR;
            $query = "DELETE FROM terdapatdi WHERE idR = $region";
            $this->db->executeNonSelectQuery($query);
            foreach ($arrKota as $key=>$value) {
                $que = "INSERT INTO terdapatdi VALUES ('$value', '$region')";
                $this->db->executeNonSelectQuery($que);
            }
            $myObj->status = true;
            $myObj->pesan = "Berhasil mengubah region";
            return json_encode($myObj);
        }

        public function viewEditRegion() {
            $res = $this->getRegions();
            $rez = $this->getKotas();
            return View::render('edit_region.php', [
                "regions" => $res,
                "kotas" => $rez,
                "title" => "Edit Region - Wombat Inc. CRM"
            ]);
        }

        public function viewModifyClientCS() {
            $clients = $this->getAllClient();
            $cs = $this->getCS();
            return View::render('modify_client_cs.php', [
                "clients" => $clients,
                "cs" => $cs,
                "title" => "Modify Client-CS - Wombat Inc. CRM"
            ]);
        }

        private function getAllClient() {
            $query = "SELECT viewUmurClient.*, users.nama, kota.namaKota 
                FROM viewUmurClient INNER JOIN kota on viewUmurClient.alamat = kota.idK
                INNER JOIN users on viewUmurClient.idU = users.idU";
            $res = $this->db->executeSelectQuery($query);
            
            $clients = [];
            foreach ($res as $client) {
                $clients[] = new Client($client['idC'], $client['namaClient'], $client['statusKawin'],
                    $client['tanggalLahir'], $client['nilaiInvestasi'], $client['namaKota'], $client['gender'],
                    $client['nama'], $client['umur']);
            }

            return $clients;
        }

        public function getClient() {
            $idClient = $this->db->escapeString($_GET['id']);
            $query = "SELECT viewUmurClient.*, users.nama, kota.namaKota 
            FROM viewUmurClient INNER JOIN kota on viewUmurClient.alamat = kota.idK
            INNER JOIN users on viewUmurClient.idU = users.idU
            WHERE viewUmurClient.idC = $idClient";
            $res = $this->db->executeSelectQuery($query);
            return json_encode($res);
        }

        public function changeCSCLient() {
            $myObj = (object)array();
            $masuk = json_decode(file_get_contents('php://input'));
            $idClient = $this->db->escapeString($masuk->idClient);
            $idCS = $this->db->escapeString($masuk->idCS);

            $query = "SELECT idC FROM client WHERE idC = $idClient";
            $res = $this->db->executeSelectQuery($query);
            $que = "SELECT idU FROM users WHERE idU = $idCS";
            $result = $this->db->executeSelectQuery($que);
            if (count($res) > 0 && count($result) > 0) {
                $ques = "UPDATE client SET idU = $idCS WHERE idC = $idClient";
                $this->db->executeNonSelectQuery($ques);
                $myObj->data = $idClient;
                $myObj->pesan = "Client berhasil di ubah";
                $myObj->status = true;
                return json_encode($myObj);
            } else {
                $myObj->data = $idClient;
                $myObj->pesan = "Client gagal di ubah";
                $myObj->status = false;
                return json_encode($myObj);
            }
        }

        private function cekKota($namakot) {
            $nama = $this->db->escapeString($namakot);
            $query = "SELECT idK FROM kota wHERE namaKota = '$nama'";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }

        private function cekRegion($namareg) {
            $nama = $this->db->escapeString($namareg);
            $query = "SELECT idR FROM region WHERE namaRegion = '$nama'";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }

        private function cekKotaId($namakot) {
            $nama = $this->db->escapeString($namakot);
            $query = "SELECT idK FROM kota wHERE idK = '$nama'";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }

        private function cekRegionId($namareg) {
            $nama = $this->db->escapeString($namareg);
            $query = "SELECT idR FROM region WHERE idR = '$nama'";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }

        private function cekArrKota($array) {
            foreach($array as $key=>$value){
                if (!$this->cekKotaId($value)) {
                    return false;
                }
            }

            return true;
        }

        private function cekArrReg($array) {
            foreach ($array as $key=>$value) {
                if (!$this->cekRegionId($value)) {
                    return false;
                }
            }
            
            return true;
        }
        
        private function getIdKota($namakot) {
            $namakot = $this->db->escapeString($namakot);
            $query = "SELECT idK FROM kota WHERE namaKota = '$namakot'";
            $res = $this->db->executeSelectQuery($query);
            return $res[0]['idK'];
        }
        
        private function getIdRegion($namareg) {
            $namareg = $this->db->escapeString($namareg);
            $query = "SELECT idR FROM region WHERE namaRegion = '$namareg'";
            $res = $this->db->executeSelectQuery($query);
            return $res[0]['idR'];
        }

        public function deleteCS() {
            $myObj = (object)array();
			$masuk = json_decode(file_get_contents('php://input'));
            $idC = $this->db->escapeString($masuk->id);
			if ($this->cekCSByID($idC)){
                if ($this->cekCSClient($idC)) {
                    $myObj->data = $idC;
				    $myObj->pesan = "CS masih memiliki klien, pindahkan klien terlebih dahulu";
				    $myObj->status = false;
				    return json_encode($myObj);
                } else {
                    $query = "DELETE FROM users WHERE idU = $idC";
				    $this->db->executeNonSelectQuery($query);
				    $myObj->data = $idC;
				    $myObj->pesan = "Data berhasil dihapus";
				    $myObj->status = true;
				    return json_encode($myObj);
                }
				
			} else {
				$myObj->data = $idC;
				$myObj->pesan = "CS tidak ditemukan";
				$myObj->status = false;
				return json_encode($myObj);
			}
        }

        public function cekCSByID($id) {
            $query = "SELECT * FROM users WHERE idU = $id";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }

        public function cekCSClient($id) {
            $query = "SELECT * FROM client WHERE idU = $id";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
        }
    }
?>