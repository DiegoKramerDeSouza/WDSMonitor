<?php 
	require_once './class/entity/operacao.php';
	class operacaoDAO extends operacao{
		private $connect;
		private $result = "";
		private $table = "operacao";
		private $operacao;
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
		public function setAll($id, $where){
			$operacao = new operacao();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
					while($obj = $exec->fetch_assoc()){
					$operacao->setid($obj["id"]);
					$operacao->setname($obj["name"]);
				}
				$this->operacao = array($operacao->getid(),$operacao->getname());
				return true;
			} else {
				return false;
			}
		}
		public function getEveryThing(){
			$operacao = new operacao();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$operacao->setid($obj["id"]);
					$operacao->setname($obj["name"]);
					array_push($result, array($operacao->getid(),$operacao->getname()));
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function countOPE(){
			$operacao = new operacao();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			return $count;
		}
		public function insertOPE($name){
			$operacao = new operacao();
			$sql = "INSERT INTO $this->table (id, name) VALUES (NULL, '$name')";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			if($exec){
				$newid = mysqli_insert_id($this->connect->getCon());
			} else {
				$newid = false;
			}
			return $newid;
		}
		public function deleteOPE($query){
			$operacao = new operacao();
			$sql = "DELETE FROM $this->table WHERE $query";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		public function updateOPE($id, $name){
			$operacao = new operacao();
			$sql = "UPDATE $this->table SET name = '$name' WHERE $this->table.id = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		public function getOPEname($id){
			$operacao = new operacao();
			$sql = "SELECT name FROM $this->table WHERE id = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
					$operacao->setname($obj["name"]);
					$result = $operacao->getname();
				}
				return $result;
			} else {
				return false;
			}
		}
		
		
		public function getoperacao(){
			return $this->operacao;
		}
		public function setoperacao($operacao){
			$this->operacao = $operacao;
		}
	}

?>