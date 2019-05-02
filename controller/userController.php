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
			$query = "SELECT idU, nama, status FROM users WHERE username = '$name'";
            $res = $this->db->executeSelectQuery($query);
            return $res[0];
		}

		public function getSelfInfo() {
			$query = "SELECT username, nama FROM users WHERE idU = $_SESSION[id]";
			$res = $this->db->executeSelectQuery($query);
			return $res[0];
		}

		private function getSelfMail() {
			$query = "SELECT kontak FROM kontak WHERE idU = $_SESSION[id]";
			$res = $this->db->executeSelectQuery($query);
			return $res;
		}

		public function viewSelfInfo() {
			$personalInfo = $this->getSelfInfo();
			$mail = $this->getSelfMail();
			return View::render('profile_settings.php', [
				"person" => $personalInfo,
				"mail" => $mail,
				"title" => "Edit Profile - Wombat Inc. CRM"
			]);
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
					$_SESSION["status"] = $arrUserData["status"];
                    
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
			$myObj = (object)array();
			$masuk = json_decode(file_get_contents('php://input'));
			$arrEmail = $this->escapeArray($masuk->email);
			$username = $this->db->escapeString($masuk->user);
			$oldpass = $this->db->escapeString($masuk->oldpass);
			$newpass = '';
			if (isset($masuk->newpass)) {
				$newpass = $this->db->escapeString($masuk->newpass);
			}
			$nama = $this->db->escapeString($masuk->nama);
			$id = $this->getId($username);
			$besar = count($arrEmail);
			if (isset($username, $oldpass, $nama)) {
				if (!$this->cekPass($username, $oldpass)) {
					$myObj->pesan = "Password salah";
					$myObj->status = false;
					return json_encode($myObj);
				}
				if ($besar > 0) {
					$que = "DELETE FROM kontak WHERE idU = $id";
            		$this->db->executeNonSelectQuery($que);
					$hashpass = password_hash($newpass, PASSWORD_DEFAULT);
					$query = "UPDATE users SET username = '$username', nama = '$nama'
						WHERE username = '$username'";
					$this->db->executeNonSelectQuery($query);
					if ($newpass != '') {
						$query = "UPDATE users SET password = '$hashpass'
							WHERE username = '$username'";
						$this->db->executeNonSelectQuery($query);
					}
					foreach ($arrEmail as $value) {
						$ques = "INSERT INTO kontak (idU, kontak) VALUES ('$id', '$value')";
                		$this->db->executeNonSelectQuery($ques);
					}
					$myObj->pesan = "Data user berhasil diubah";
					$myObj->status = true;
					return json_encode($myObj);
				} else {
					$myObj->pesan = "Email harus diisi";
					$myObj->status = false;
					return json_encode($myObj);
				}
			} else {
				$myObj->pesan = "Data tidak lengkap";
				$myObj->status = false;
				return json_encode($myObj);
			}
		}
    }
?>