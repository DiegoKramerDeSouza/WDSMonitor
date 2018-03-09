<?php 
	require_once './class/entity/ciclo.php';
	class cicloDAO extends ciclo{
		private $connect;
		private $result = "";
		private $table = "ciclo";
		private $ciclo;
		public function __construct(){
			$this->connect = new connect();
		}
		public function getContent($id, $where, $content){
			$sql = "SELECT $content FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
					$this->result = $obj[$content];
				}
				return $this->result;
			} else {
				return false;
			}
		}
		public function getEveryThing(){
			$ciclo = new ciclo();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$ciclo->setid($obj["id"]);
					$ciclo->setOperacao_id($obj["Operacao_id"]);
					$ciclo->setname($obj["name"]);
					array_push($result, array($ciclo->getid(),$ciclo->getOperacao_id(),$ciclo->getname()));
				}
				return $result;
			} else {
				return false;
			}
		}
		public function setAll($id, $where){
			$ciclo = new ciclo();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
				$ciclo->setid($obj["id"]);
				$ciclo->setOperacao_id($obj["Operacao_id"]);
				$ciclo->setname($obj["name"]);
			}
			$this->ciclo = array($ciclo->getid(),$ciclo->getOperacao_id(),$ciclo->getname());
				return true;
			} else {
				return false;
			}
		}
		public function insertCIC($setorid, $name){
			$ciclo = new ciclo();
			$sql = "INSERT INTO $this->table (id, Operacao_id, name) VALUES (NULL, '$setorid', '$name')";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			if($exec){
				$newid = mysqli_insert_id($this->connect->getCon());
			} else {
				$newid = false;
			}
			return $newid;
		}
		public function deleteCIC($query){
			$ciclo = new ciclo();
			$sql = "DELETE FROM $this->table WHERE $query";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		public function countCIC(){
			$ciclo = new ciclo();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			return $count;
		}
		public function updateCIC($id, $setorid, $name){
			$ciclo = new ciclo();
			$sql = "UPDATE $this->table SET Operacao_id = '$setorid', name = '$name' WHERE $this->table.id = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function getciclo(){
			return $this->ciclo;
		}
		public function setciclo($ciclo){
			$this->ciclo = $ciclo;
		}
	}

?>