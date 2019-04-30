<?php
	require_once "mysqlDB.php";
	class clientModel{
			
		public function getClient($namaClients){
			$query = "SELECT * FROM client WHERE namaClient = '$namaClients'";
			$result = $db->executeSelectQuery($query);
			return $result;
		}
		
		public function setClient($namaClients,$nilai,$status,$alamat){
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
