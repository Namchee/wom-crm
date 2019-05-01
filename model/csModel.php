<?php
	require_once "mysqlDB.php";
	require_once "userModel.php";
	session_start();
	
	class csModel{
		public function getClient($namaClients){
			$namaC = $db->escapeString($namaClients);
			$query = "SELECT * FROM client WHERE namaClient = '$namaC'";
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
			$result = $query;
			$nilaiBaru = $nilai;
			$statusBaru =$status;
			$alamatBaru = $alamat;
			if(isset($nama,$alamatBaru,$statusBaru,$nilaiBaru)){
				$que = "UPDATE client SET nilaiInvestasi=$nilaiBaru,alamat='$alamatBaru',statusKawin='$statusBaru'
				WHERE namaClient='$nama'";
				$db->executeNonSelectQuery($que);
			}
		}
		
		public function addClient(){
			$masuk = json_decode(file_get_contents('php://input'));
			$nama = $db->escapeString($masuk->namaClient);
			$nilaiInvest = $db->escapeString($masuk->nilaiInvestasi);
			$kelamin = $db->escapeString($masuk->gender);
			$alamat = $db->escapeStrin($masuk->alamat);
			$status = $db->escapeString($masuk->statusKawin);
			$birthday = $db->escapeString($masuk->tanggalLahir);
			if(cekClient($nama)){
				$myObj->data=$nama;
				$myObj->pesan="Client sudah ada";
				$myObj->status=false;
				echo json_encode($myObj);
			}else{
				$query="INSERT INTO client (namaClient,nilaiInvestasi,gender,alamat,statusKawin,tanggalLahir) 
				VALUES ('$nama',$nilaiInvest,$kelamin,$alamat,$status,'birthday',$_SESSION["id"])";
				$db->executeNonSelectQuery($query);
				$myObj->data=$nama;
				$myObj->pesan="Berhasil tambah client";
				$myObj->status=true;
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
		
		public function getClientCS(){
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
		public function kategoriReport(){
			$masuk = json_decode(file_get_contents('php://input'));
			$kategori=$db->escapeString($masuk->kategori);
			$idUser = $_SESSION["id"];
			if($kategori==1){
				$query="SELECT kotaReport.namaKota, convert(float,kotaReport.jumlah)
					FROM(
					      SELECT Kota.namaKota, count(client.idC) as 'jumlah'
					      FROM users INNER JOIN client on users.idU=client.idU 
					      INNER JOIN kota on client.alamat=kota.idK
					      WHERE client.idU=$idUser
					      GROUP BY kota.namaKota
					)as kotaReport";
				$res=$db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
				echo json_encode($myObj);
			}else if($kategori==2){
				$query="SELECT regRep.namaRegion, convert(float,regRep.jumlah)
					FROM(
					      SELECT region.namaRegion, count(client.idC) as 'jumlah'
					      FROM users INNER JOIN client on users.idU=client.idU 
					      INNER JOIN kota on client.alamat=kota.idK
					      INNER JOIN terdapatdi on kota.idK=terdapatdi.idK
					      INNER JOIN region on terdapatdi.idR=region.idR
					      WHERE client.idU=$idUser
					      GROUP BY region.namaRegion
					)as regRep";
				$res=$db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
				echo json_encode($myObj);
			}else if($kategori==3){
				$query="SELECT nilaiRep.rangeNilai, convert(float,nilaiRep.jumlah)
					FROM(
						SELECT (nilaiInvestasi/200000)*200000||'-'||(nilaiInvestasi/200000)*200000+199999 as 'rangeNilai', count(idC) as 'jumlah'
						FROM client INNER JOIN users on client.idU=users.idU
						WHERE client.idU=$idUser
						GROUP BY nilaiInvestasi/20000
						ORDER BY 1
					)as nilaiRep";
				$res=$db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
				echo json_encode($myObj);
			}else if($kategori==4){
				$query="SELECT umurRep.rangeUmur, convert(float,umurRep.jumlah)
						SELECT (age/10)*10||'-'||(age/10)*10+9 as 'rangeUmur', count (idC) as 'jumlah'
						FROM viewUmurClient INNER JOIN users on viewUmurClient.idU=users.idU
						WHERE viewUmurClient.idU=$idUser
						GROUP BY age/10
						ORDER BY 1
					)as umurRep";
				$res=$db->executeSelectQuery($query);
				$myObj->arrayRes = $res;
				echo json_encode($myObj);
			}
		}
	}
?>
