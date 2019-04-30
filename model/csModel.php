<?php
	require_once "mysqlDB.php";
	require_once "clientModel.php";
	require_once "userModel.php";
	session_start();
	
	class csModel{
		public function addClient(){
			$masuk = json_decode(file_get_contents('php://input'));
			$nama = $masuk->namaClient;
			$nilaiInvest = $masuk->nilaiInvestasi;
			$kelamin = $masuk->gender;
			$alamat = $masuk->alamat;
			$status = $masuk->statusKawin;
			$birthday = $masuk->tanggalLahir;
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
			$idC = $masuk->idClient;
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
		}
		
		public function makeReport(){}
		
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
			$query = "SELECT * FROM client WHERE namaClient = '$namaClients'";
			$result = $db->executeSelectQuery($query);
			$nilaiBaru = $nilai;
			$statusBaru = $status;
			$alamatBaru = $alamat;
			$nama = $namaClients;
			if(isset($nama,$alamatBaru,$statusBaru,$nilaiBaru)){
				$que = "UPDATE client SET nilaiInvestasi=$nilaiBaru,alamat='$alamatBaru',statusKawin='$statusBaru' WHERE namaClient='$nama'";
				$db->executeSelectQuery($que);
			}
		}
	}
?>
