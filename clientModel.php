<?php
	require_once "mysqlDB.php";
	class clientModel{
			
		public function getClient($namaClients){
			$query = "SELECT * FROM client WHERE namaClient = $namaClients";
			$result = $db->executeSelectQuery($query);
			return $result;
		}
		
		private function getIdClient($namaClients){
			$query = "SELECT idC FROM client WHERE namaClient = $namaClients";
			$result = $db->executeSelectQuery($query);
			return $result[0];
		}
		
		public function setGambar($gambar,$nama){
			$query = "UPDATE client SET gambar=$gambar WHERE namaClient=$nama";
			$db->executeNonSelectQuery($query);
		}
		
		public function setClient($namaClients,$nilai,$status,$alamat){
			$nilaiBaru = $nilai;
			$statusBaru = $status;
			$alamatBaru = $alamat;
			$nama = $namaClients;
			if($nilaiBaru!=null && $statusBaru != null && $alamatBaru!=null){
				$que = "UPDATE client SET nilaiInvestasi=$nilaiBaru,statusKawin=$statusBaru,alamat=$alamatBaru WHERE namaClient=$nama";
				$db->executeNonSelectQuery($que);
			}else{
				if($alamatBaru!=null){
					if($nilaiBaru!=null){
						$que = "UPDATE client SET nilaiInvestasi=$nilaiBaru,alamat=$alamatBaru WHERE namaClient=$nama";
						$db->executeNonSelectQuery($que);
					}else if($statusBaru!=null){
						$que = "UPDATE client SET statusKawin=$statusBaru,alamat=$alamatBaru WHERE namaClient=$nama";
						$db->executeNonSelectQuery($que);
					}else{
						$que = "UPDATE client SET alamat=$alamatBaru WHERE namaClient=$nama";
						$db->executeNonSelectQuery($que);
					}
				}else if($nilaiBaru!=null){
					if($statusBaru!=null){
						$que = "UPDATE client SET nilaiInvestasi=$nilaiBaru,statusKawin=$statusBaru WHERE namaClient=$nama";
						$db->executeNonSelectQuery($que);
					}else{
						$que = "UPDATE client SET nilaiInvestasi=$nilaiBaru WHERE namaClient=$nama";
						$db->executeNonSelectQuery($que);
					}
				}else if($statusBaru!=null){
					$que = "UPDATE client SET statusKawin=$statusBaru WHERE namaClient=$nama";
						$db->executeNonSelectQuery($que);
				}
			}
		}
	}
?>
