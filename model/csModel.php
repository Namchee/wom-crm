<?php
	require_once "mysqlDB.php";
	require_once "userModel.php";
	session_start();
	
	class csModel{
		public function addClient(){
			$masuk = json_decode(file_get_contents('php://input'));
			$nama = $db->escapeString($masuk->namaClient);
			$nilaiInvest = $db->escapeString($masuk->nilaiInvestasi);
			$kelamin = $db->escapeString($masuk->gender);
			$alamat = $db->escapeStrin($masuk->alamat);
			$status = $db->escapeString($masuk->statusKawin);
			$birthday = $db->escapeString($masuk->tanggalLahir);
			if(cekClient($nama)){
				$query="INSERT INTO client (namaClient,nilaiInvestasi,gender,alamat,statusKawin,tanggalLahir) 
				VALUES ('$nama',$nilaiInvest,$kelamin,$alamat,$status,'birthday',$_SESSION["id"])";
				$db->executeSelectQuery($query);
				$myObj->data=$nama;
				$myObj->pesan="Berhasil tambah client";
				$myObj->status=true;
				echo json_encode($myObj);
			}else{
				$myObj->data=$nama;
				$myObj->pesan="Gagal tambah client";
				$myObj->status=false;
				echo json_encode($myObj);
			}
		}
		
		public function deleteClient(){
			$masuk = json_decode(file_get_contents('php://input'));
			$idC = $db->escapeString($masuk->idClient);
			if(cekIdClient($idC)){
				$query = "DELETE FROM client WHERE idC=$idC";
				$db->executeNonSelectQuery($query);
				$myObj->data=$idC;
				$myObj->pesan="Data berhasil dihapus";
				$myObj->status=true;
				echo json_encode($myObj);
			}else{
				$myObj->data=$idC;
				$myObj->pesan="Data tidak ditemukan";
				$myObj->status=false;
				echo json_encode($myObj);
			}
		}
			
		public function editClient(){
			$masuk = json_decode(file_get_contents('php://input'));
			$id = $db->escapeString($masuk->idC);
			$nama = $db->escapeString($masuk->namaClient);
			$nilaiInvest = $db->escapeString($masuk->nilaiInvestasi);
			$status = $db->escapeString($masuk->statusKawin);
			$alamat = $db->escapeString($masuk->alamat);
			if(cekIdClient($id)){
				setClient($nama,$nilaiInvest,$status,$alamat);
				$myObj->status=true;
				$myObj->pesan = "client berhasil diubah";
				echo json_encode($myObj);
			}else{
				$myObj->status=false;
				$myObj->pesan = "client gagal diubah";
				echo json_encode($myObj);
			}
		}
		
		public function getClient($namaClients){
			$query = "SELECT * FROM client WHERE namaClient = '$namaClients'";
			$result = $db->executeSelectQuery($query);
			return $result;
		}
		
		private function cekClient($nama){
			$query = "SELECT idC FROM client WHERE namaClient='$nama'";
			$res=$db->executeSelectQuery($query);
			if($res){
				return true;
			}else{
				return false;
			}
		}

		private function cekIdClient($idC){
			$query = "SELECT namaClient FROM client WHERE idC=$idC";
			$res=$db->executeSelectQuery($query);
			if($res){
				return true;
			}else{
				return false;
			}
		}
		
		private function setClient($namaClients,$nilai,$status,$alamat){
			$nama = $namaClients;
			$query = "SELECT * FROM client WHERE namaClient = '$nama'";
			$result = $query;
			$nilaiBaru = $nilai;
			$statusBaru =$status;
			$alamatBaru = $alamat;
			if(isset($nama,$alamatBaru,$statusBaru,$nilaiBaru)){
				$que = "UPDATE client SET nilaiInvestasi=$nilaiBaru,alamat='$alamatBaru',statusKawin='$statusBaru' WHERE namaClient='$nama'";
				$db->executeSelectQuery($que);
			}
		}
		
		public function getClientCS{
			$masuk = json_decode(file_get_contents('php://input'));
			$idClient = $db->escapeString($masuk->idC);
			if(cekIdClient($idClient)){
				$query = "SELECT users.idU,users.nama FROM users INNER JOIN client on users.idU=client.idU
				WHERE client.idC=$idClient";
				$res=$db->executeSelectQuery($query);
				$myObj->idCS = $res[0];
				$myObj->nama = $res[1];
				$myObj->status = true;
				echo json_encode($myObj);
			}else{
				$myObj->pesan = "Client tidak ada";
				$myObj->status = false;
				echo json_encode($myObj);
			}
		}
	}
?>
