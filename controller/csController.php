<?php
    require_once 'services/mysqldb.php';
    require_once 'services/view.php';

    class CsController {
        private $db;

        public function __construct() {
            $this->db = new MySQLDB("localhost", "root", "", "crm");
        }

        public function viewDashboard() {

        }

        public function getClientCS($idC) {
            $cs = (object)array();
			$idClient = $this->db->escapeString($masuk->idC);
			if (cekIdClient($idClient)) {
				$query = "SELECT users.idU, users.nama FROM users INNER JOIN client on users.idU = client.idU
				WHERE client.idC = $idClient";
				$res = $this->db->executeSelectQuery($query);
                $cs->idCS = $res[0]['idU'];
                $cs->namaCS = $res[0]['nama'];
                return $cs;
			} else {
				return null;
			}
        }
        
        private function cekIdClient($idC) {
			$query = "SELECT namaClient FROM client WHERE idC=$idC";
			$res = $db->executeSelectQuery($query);
            return count($res) > 0;
		}
    }
?>