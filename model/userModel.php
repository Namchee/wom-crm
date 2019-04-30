<?php
	require_once "mysqlDB.php";
	
	class userModel{
		
		private function cekUsers($nama){
			$query = "SELECT username FROM users WHERE username = '$nama'";
            		$res = $db->executeSelectQuery($query);
            		if($res){
                		return true;
            		}
            		else{
                		return false;
            		}
		}
		
		private function cekPass($user,$pass){
            		$query = "SELECT password FROM users WHERE username='$user'";
			$res = $db->executeSelectQuery($query);
			if(password_verify($pass,$res[0])){
				return true;
			}else{
				return false;
			}
		}
		
		private function getUser($nama){
			$query = "SELECT idU,nama,status FROM users WHERE username = '$nama'";
            		$res = $db->executeSelectQuery($query);
            		return $res;
		}
		
		private function cekActive($user){
			$query = "SELECT active FROM users WHERE username = '$user'";
            		$res = $db->executeSelectQuery($query);
            		return $res[0];
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
			$userName = $masuk->user;
			$pass = $masuk->password;
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
		
		public function logout(){
			session_unset();
			session_destroy();
		}
	}
?>
