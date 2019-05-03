<?php
    require_once 'services/mysqldb.php';
    require_once 'services/view.php';
    require_once 'model/clientModel.php';
    require_once 'model/kotaModel.php';
    require_once 'model/regionModel.php';

    class CsController {
        private $db;

        public function __construct() {
            $this->db = new MySQLDB("localhost", "root", "", "crm");
        }

        public function viewDashboard() {
            $clients = $this->getClients();
            return View::render('cs_dashboard.php', [
                "clients" => $clients,
                "title" => "Customer Service Dashboard - Wombat Inc. CRM"
            ]);
        }

        public function viewAddClient() {
            $kotas = $this->getKotas();
            return View::render('add_client.php', [
                "kotas" => $kotas,
                "title" => "Add New Client - Wombat Inc. CRM"
            ]);
        }

        public function addClient() {
            $myObj = (object)array();
            $masuk = json_decode(file_get_contents('php://input'));
			$nama = $this->db->escapeString($masuk->namaClient);
			$nilaiInvest = $this->db->escapeString($masuk->nilaiInvestasi);
			$kelamin = $this->db->escapeString($masuk->gender);
			$alamat = $this->db->escapeString($masuk->alamat);
			$status = $this->db->escapeString($masuk->statusKawin);
			$birthday = $this->db->escapeString($masuk->tanggalLahir);
			$query="INSERT INTO client (namaClient, nilaiInvestasi, gender, alamat, statusKawin, tanggalLahir, idU) 
			VALUES ('$nama', $nilaiInvest, $kelamin, $alamat, $status, '$birthday', $_SESSION[id])";
			$this->db->executeNonSelectQuery($query);
			$myObj->data = $nama;
			$myObj->pesan = "Berhasil tambah client";
			$myObj->status = true;
			return json_encode($myObj);
        }
        
        public function viewReport() {
            return View::render('static/view_report.html', [
                "title" => "View Report - Wombat Inc. CRM"
            ]);
        }

        private function getClients() {
            $query = "SELECT viewUmurClient.*, users.nama, kota.namaKota 
                FROM viewUmurClient INNER JOIN kota on viewUmurClient.alamat = kota.idK
                INNER JOIN users on viewUmurClient.idU = users.idU
                WHERE viewUmurClient.idU = $_SESSION[id]";
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
            $query = "SELECT viewUmurClient.*, users.nama, kota.namaKota, kota.idK 
                FROM viewUmurClient INNER JOIN kota on viewUmurClient.alamat = kota.idK
                INNER JOIN users on viewUmurClient.idU = users.idU
                WHERE viewUmurClient.idC = $idClient";
            $res = $this->db->executeSelectQuery($query);
            return json_encode($res);
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

        private function getRegions() {
            $query = "SELECT * FROM region";
            $res = $this->db->executeSelectQuery($query);
            $regions = [];
            foreach ($res as $key=>$value) {
                $regions[] = new Region($value['idR'], $value['namaRegion']);
            }
            return $regions;
        }

        public function kategoriReport() {
            $myObj = (object)array();
			$masuk = json_decode(file_get_contents('php://input'));
			$kategori = $this->db->escapeString($masuk->kategori);
			$idUser = $_SESSION["id"];
			if ($kategori == 1) {
				$query = "SELECT kotaReport.namaKota as x, kotaReport.jumlah as y
					FROM (
					      SELECT Kota.namaKota, count(viewUmurClient.idC) as 'jumlah'
					      FROM users INNER JOIN viewUmurClient on users.idU = viewUmurClient.idU
					      INNER JOIN kota on viewUmurClient.alamat = kota.idK
					      WHERE viewUmurClient.idU = $idUser
					      GROUP BY kota.namaKota
					) as kotaReport";
				$res = $this->db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
				return json_encode($myObj);
			} else if ($kategori == 2) {
				$query = "SELECT regRep.namaRegion as x, regRep.jumlah as y
					FROM (
					      SELECT region.namaRegion, count(client.idC) as 'jumlah'
					      FROM users INNER JOIN client on users.idU=client.idU 
					      INNER JOIN kota on client.alamat=kota.idK
					      INNER JOIN terdapatdi on kota.idK=terdapatdi.idK
					      INNER JOIN region on terdapatdi.idR=region.idR
					      WHERE client.idU = $idUser
					      GROUP BY region.namaRegion
					) as regRep";
				$res = $this->db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
				return json_encode($myObj);
			} else if ($kategori == 3) {
                $query = "SELECT nilaiRep.rangeNilai as x, nilaiRep.jumlah as y FROM ( SELECT concat(TRIM((nilaiInvestasi/200000)*200000) + 0, '-', TRIM((nilaiInvestasi/200000)*200000+199999) + 0) as 'rangeNilai', count(idC) as 'jumlah' FROM viewUmurClient INNER JOIN users on viewUmurClient.idU=users.idU WHERE viewUmurClient.idU = $idUser GROUP BY nilaiInvestasi/200000 ORDER BY 1 ) as nilaiRep";
				$res = $this->db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
				return json_encode($myObj);
			} else if ($kategori == 4) {
                $query = "SELECT umurRep.rangeUmur as x, umurRep.jumlah as y FROM ( SELECT concat(TRIM((umur/10)*10) + 0, '-' ,TRIM((umur/10)*10+10) + 0) as 'rangeUmur', count(idC) as 'jumlah' FROM viewUmurClient INNER JOIN users on viewUmurClient.idU=users.idU WHERE viewUmurClient.idU = $idUser GROUP BY umur / 10 ) as umurRep";
				$res = $this->db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
			    return json_encode($myObj);
			}
        }

        public function viewSearchRegion() {
            $regions = $this->getRegions();
            return View::render('search_region.php', [
                "regions" => $regions,
                "title" => "Search Region - Wombat Inc. CRM"
            ]);
        }

        public function viewEditClient() {
            $clients = $this->getClients();
            $kotas = $this->getKotas();
            return View::render('edit_client.php', [
                "clients" => $clients,
                "kotas" => $kotas,
                "title" => "Edit Client - Wombat Inc. CRM"
            ]);
        }
        
        public function getClientByRegion() {
            $myObj = (object)array();     
            $region = $this->db->escapeString($_GET['id']);
            
            $query = "SELECT viewUmurClient.*, users.nama, kota.namaKota 
                FROM viewUmurClient INNER JOIN kota on viewUmurClient.alamat = kota.idK
                INNER JOIN users on viewUmurClient.idU = users.idU
                INNER JOIN terdapatdi on kota.idK = terdapatdi.idK
                INNER JOIN region on terdapatdi.idR = region.idR
                WHERE region.idR = $region";
            $res = $this->db->executeSelectQuery($query);
            
            $clients = [];
            foreach ($res as $client) {
                $clients[] = new Client($client['idC'], $client['namaClient'], $client['statusKawin'],
                    $client['tanggalLahir'], $client['nilaiInvestasi'], $client['namaKota'], $client['gender'],
                    $client['nama'], $client['umur']);
            }
            return json_encode($clients);
        }

        private function setClient($id, $namaClients,$nilai,$status,$alamat,$tanggal, $gender) {
			$nama = $namaClients;
			$nilaiBaru = $nilai;
			$statusBaru = $status;
            $alamatBaru = $alamat;
			if (isset($nama, $alamatBaru, $statusBaru, $nilaiBaru, $tanggal)) {
				$que = "UPDATE client SET nilaiInvestasi = '$nilaiBaru', alamat = '$alamatBaru', statusKawin= '$statusBaru'
                    , tanggalLahir = '$tanggal'
                    , namaClient = '$namaClients'
                    , gender = '$gender'
                    WHERE idC = $id";
                $this->db->executeNonSelectQuery($que);
                return true;
            }
            
            return false;
        }
        
        public function editClient() {
            $myObj = (object)array();
			$masuk = json_decode(file_get_contents('php://input'));
			$id = $this->db->escapeString($masuk->idC);
			$nama = $this->db->escapeString($masuk->namaClient);
			$nilaiInvest = $this->db->escapeString($masuk->nilaiInvestasi);
			$status = $this->db->escapeString($masuk->statusKawin);
            $alamat = $this->db->escapeString($masuk->alamat);
            $tanggal = $this->db->escapeString($masuk->tanggalLahir);
            $gender = $this->db->escapeString($masuk->gender);
			if ($this->cekIdClient($id)) {
				$res = $this->setClient($id, $nama, $nilaiInvest, $status, $alamat, $tanggal, $gender);
				if ($res) {
                    $myObj->status = true;
                    $myObj->pesan = "Data client berhasil diubah";
                    return json_encode($myObj);
                } else {
                    $myObj->status = false;
                    $myObj->pesan = "Data client gagal diubah";
                    return json_encode($myObj);
                }
			} else {
				$myObj->status = false;
				$myObj->pesan = "Client tidak terdaftar";
				return json_encode($myObj);
			}
        }

        public function deleteClient() {
            $myObj = (object)array();
			$masuk = json_decode(file_get_contents('php://input'));
			$idC = $this->db->escapeString($masuk->idClient);
			if ($this->cekIdClient($idC)){
				$query = "DELETE FROM client WHERE idC = $idC";
				$this->db->executeNonSelectQuery($query);
				$myObj->data = $idC;
				$myObj->pesan = "Data berhasil dihapus";
				$myObj->status = true;
				return json_encode($myObj);
			} else {
				$myObj->data = $idC;
				$myObj->pesan = "Data tidak ditemukan";
				$myObj->status = false;
				return json_encode($myObj);
			}
		}
        
        private function cekIdClient($idC) {
			$query = "SELECT namaClient FROM viewUmurClient WHERE idC = $idC";
			$res = $this->db->executeSelectQuery($query);
			return count($res) > 0;
		}
    }
?>