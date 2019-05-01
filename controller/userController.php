<?php
    require_once 'services/mysqldb.php';
    require_once 'services/view.php';

    class UserController {
        private $db;

        public function  __construct() {
            $this->db = new MySQLDB("localhost", "root", "", "crm");
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
    }
?>