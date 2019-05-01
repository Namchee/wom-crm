<?php
	require_once "mysqlDB.php";
	
	class userModel{
		
		private function cekUsers($nama){
			$namas = $db->escapeString($nama);
			$query = "SELECT username FROM users WHERE username = '$namas'";
            		$res = $db->executeSelectQuery($query);
            		if($res){
                		return true;
            		}
            		else{
                		return false;
            		}
		}
		
		private function cekPass($user,$pass){
			$username=$db->escapeString($user);
			$password=$db->escapeString($pass);
            		$query = "SELECT password FROM users WHERE username='$username'";
			$res = $db->executeSelectQuery($query);
			if(password_verify($password,$res[0])){
				return true;
			}else{
				return false;
			}
		}
		
		private function getUser($nama){
			$name=$db->escapeString($nama);
			$query = "SELECT idU,nama,status FROM users WHERE username = '$name'";
            		$res = $db->executeSelectQuery($query);
            		return $res;
		}
		
		public function cekActive($user){
			$username = $db->escapeString($user);
			$query = "SELECT active FROM users WHERE username = '$username'";
            		$res = $db->executeSelectQuery($query);
            		if($res[0]==0){
				return false;
			}else{
				return true;
			}
		}
		
		public function getUsers(){
			$query = "SELECT idU,nama,tanggalGabung,username,active,password FROM users";
			$res=$db->executeSelectQuery($query);
			return $res;
		}
		
		public function getCS(){
			$query = "SELECT idU,nama,tanggalGabung,username,active,password FROM users WHERE status=0";
			$res=$db->executeSelectQuery($query);
			return $res;
		}
		
		public function login(){
			$masuk = json_decode(file_get_contents('php://input'));
			$userName = $db->escapeString($masuk->user);
			$pass = $db->escapeString($masuk->password);
			if(cekUsers($userName)){
				if(cekPass($username,$pass)){
					if(cekActive($username)){
						$arrUserData = getUser($userName);
						session_start();
						$_SESSION["id"]=$arrUserData[0];
						$_SESSION["nama"]=$arrUserData[1];
						$_SESSION["status"]=$arrUserData[2];
						$myObj->data=$userName;
						$myObj->pesan="Berhasil Log In";
						$myObj->status=true;
						echo json_encode($myObj);
					}else{
						$myObj->data=$userName;
						$myObj->pesan="User tidak aktif";
						$myObj->status=false;
						echo json_encode($myObj);
					}
				}else{
					$myObj->data=$userName;
					$myObj->pesan="Password salah";
					$myObj->status=false;
					echo json_encode($myObj);
				}
			}else{
				$myObj->data=null;
				$myObj->pesan="Tidak Berhasil Log In";
				$myObj->status=false;
				echo json_encode($myObj);
			}
		}
		private function escapeArray($array){
            		foreach($array as $value){
                	$value = $db->escapeString($value);
            		}	
        	}
		private function getId($username){
			$query = "SELECT idU FROM users WHERE username = '$username'";
            		$res = $db->executeSelectQuery($query);
            		return $res[0];
		}
		public function changeData(){
			$masuk=json_decode(file_get_contents('php://input'));
			$arrEmail = escapeArray($masuk->email);
			$username = $db->escapeString($masuk->user);
			$pass = $db->escapeString($masuk->pass);
			$nama=$db->escapeString($masuk->nama);
			$id= getId($username);
			$besar = count($arrEmail);
			if(isset($username,$pass,$nama)){
				if($besar>0){
					$que = "DELETE FROM kontak WHERE idU=$id;
            				$db->executeNonSelectQuery($que);
					$hashpass = password_hash('$pass',PASSWORD_DEFAULT);
					$query="UPDATE users SET username=$username, password=$hashpass,nama=$nama
					WHERE username=$username";
					$db->executeNonSelectQuery($query);
					foreach($arrEmail as $value){
						$ques = "INSERT INTO kontak (idU,kontak) VALUES ($id,$value)";
                				$db->executeNonSelectQuery($ques);
					}
					$myObj->pesan="Data user berhasil diubah";
					$myObj->status=true;
					echo json_encode($myObj);
				}else{
					$myObj->pesan="Email tidak ada";
					$myObj->status=false;
					echo json_encode($myObj);
				}
			}else{
				$myObj->pesan="Data gagal diubah";
				$myObj->status=false;
				echo json_encode($myObj);
			}
		}
		
		public function logout(){
			session_unset();
			session_destroy();
		}
	}
?>
