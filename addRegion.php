<?php
	require "mysqlDB.php";
	
	$masuk = json_decode(file_get_contents('php://input'));
	$quri = "SELECT namaRegion FROM Region";
	$regNama = $masuk->nama;
	$quri .= " WHERE namaRegion = $regNama";
	$result = $db->executeSelectQuery($quri);
	if($result == NULL){
		$query = "INSERT INTO region VALUES (NULL,'$regNama')";
		$result=$db->executeNonSelectQuery($query);
		$myObj->data = $masuk->nama;
		$myObj->pesan = "Region berhasil ditambah";
		$myObj->status = true;
		echo json_encode($myObj);
	}
	else{
		$myObj->data = NULL;
		$myObj->pesan = "Region tidak berhasil ditambah";
		$myObj->status = false;
		echo json_encode($myObj);
	}
?>