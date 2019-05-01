<?php
    require_once 'services/mysqldb.php';
    require_once 'services/view.php';

    class UserController {
        private $db;

        public function  __construct() {
            $this->db = new MySQLDB("localhost", "root", "", "crm");
		}
		
		private function escapeArray($array) {
			$escaped = [];

			foreach ($array as $value) {
				$escaped[] = $this->db->escapeString($value);
			}	

			return $escaped;
		}

        private function cekUsers($nama) {
			$namas = $this->db->escapeString($nama);
			$query = "SELECT username FROM users WHERE username = '$namas'";
            $res = $this->db->executeSelectQuery($query);
            return count($res) > 0;
		}
		
		private function cekPass($user, $pass) {
			$username = $this->db->escapeString($user);
			$password = $this->db->escapeString($pass);
            $query = "SELECT password FROM users WHERE username = '$username'";
            $res = $this->db->executeSelectQuery($query);
            $hash = $res[0]["password"];
            return password_verify($password, $hash);
		}
		
		private function getUser($nama) {
			$name = $this->db->escapeString($nama);
			$query = "SELECT idU, nama FROM users WHERE username = '$name'";
            $res = $this->db->executeSelectQuery($query);
            return $res[0];
		}

		public function getSelfInfo() {
			$query = "SELECT username, password, nama FROM users WHERE idU = $_SESSION[id]";
			$res = $this->db->executeSelectQuery($query);
			return $res[0];
		}

		private function getSelfMail() {
			$query = "SELECT kontak FROM kontak WHERE idU = $_SESSION[id]";
			$res = $this->db->executeSelectQuery($query);
			return $res[0];
		}

		public function viewSelfInfo() {
			$personalInfo = $this->getSelfInfo();
			$mail = $this->getSelfMail();
		}
		
		public function login() {
			$myObj = (object)array();
			$masuk = json_decode(file_get_contents('php://input'));
			$userName = $this->db->escapeString($masuk->user);
			$pass = $this->db->escapeString($masuk->password);
			if ($this->cekUsers($userName)) {
				if ($this->cekPass($userName,$pass)) {
                    $arrUserData = $this->getUser($userName);
                    
					$_SESSION["id"] = $arrUserData["idU"];
					$_SESSION["nama"] = $arrUserData["nama"];
                    
					$myObj->data = $userName;
					$myObj->pesan = "Berhasil Log In";
                    $myObj->status = true;
					return json_encode($myObj);
				} else {
					$myObj->data = NULL;
					$myObj->pesan = "Password salah";
					$myObj->status = false;
					return json_encode($myObj);
				}
			} else {
				$myObj->data = null;
				$myObj->pesan = "Username tidak terdaftar";
				$myObj->status = false;
				return json_encode($myObj);
            }
        }
		
		public function logout() {
			session_unset();
			session_destroy();
		}

		private function getId($username) {
			$query = "SELECT idU FROM users WHERE username = '$username'";
            $res = $this->db->executeSelectQuery($query);
            return $res[0]['idU'];
		}

		public function changeData() {
			$masuk = json_decode(file_get_contents('php://input'));
			$arrEmail = $this->escapeArray($masuk->email);
			$username = $this->db->escapeString($masuk->user);
			$pass = $this->db->escapeString($masuk->pass);
			$nama = $this->db->escapeString($masuk->nama);
			$id= $this->getId($username);
			$besar = count($arrEmail);
			if (isset($username, $pass, $nama)) {
				if ($besar > 0) {
					$que = "DELETE FROM kontak WHERE idU = $id";
            		$this->db->executeNonSelectQuery($que);
					$hashpass = password_hash('$pass', PASSWORD_DEFAULT);
					$query="UPDATE users SET username = '$username', password = '$hashpass', nama = '$nama' 
						WHERE idU = '$id'";
					$this->db->executeNonSelectQuery($query);
					foreach ($arrEmail as $value) {
						$ques = "INSERT INTO kontak ('idU', 'kontak') VALUES ('$id', '$value')";
                		$this->db->executeNonSelectQuery($ques);
					}
					$myObj->pesan = "Data user berhasil diubah";
					$myObj->status = true;
					return json_encode($myObj);
				} else {
					$myObj->pesan = "E-mail harus diisi";
					$myObj->status = false;
					return json_encode($myObj);
				}
			} else {
				$myObj->pesan = "Seluruh informasi wajib diisi";
				$myObj->status = false;
				return json_encode($myObj);
			}
		}
    }
?>