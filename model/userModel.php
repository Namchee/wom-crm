<?php
	require_once "mysqlDB.php";
	
	class userModel{
		
		private function cekUsers($nama){
			$query = "SELECT username FROM users wHERE username = $nama";
            $res = $db->executeSelectQuery($query);
            if($res){
                return true;
            }
            else{
                return false;
            }
		}
		
		private function cekPass($pass){
			$query = "SELECT password FROM users wHERE password = $pass";
            $res = $db->executeSelectQuery($query);
            if($res){
                return true;
            }
            else{
                return false;
            }
		}
		
		private function getUser($nama){
			$query = "SELECT * FROM users WHERE username = $nama";
            $res = $db->executeSelectQuery($query);
            return $res;
		}
		
		public function login(){
			$masuk = json_decode(file_get_contents('php://input'));
			$userName = $masuk->user;
			$pass = $masuk->password;
			if(cekUsers($userName)&&cekPass($pass)){
				$arrUserData = getUser($userName);
				session_start();
				$_SESSION["nama"]=$arrUserData[0];
				$_SESSION["tanggalGabung"]=$arrUserData[1];
				$_SESSION["username"]=$arrUserData[2];
				$_SESSION["password"]=$arrUserData[3];
				$_SESSION["idU"]=$arrUserData[4];
				$_SESSION["active"]=$arrUserData[5];
				$_SESSION["status"]=$arrUserData[6];
				$myObj->data=$userName;
				$myObj->pesan="Berhasil Log In";
				$myObj->status=true;
				json_encode($myObj);
			}else{
				$myObj->data=null;
				$myObj->pesan="Tidak Berhasil Log In";
				$myObj->status=false;
				json_encode($myObj);
			}
		}
		
		public function logout(){
			session_unset();
			session_destroy();
		}
	}
?>
