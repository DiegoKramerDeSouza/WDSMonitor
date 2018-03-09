<?php 
	require_once './class/entity/maquina.php';
	class maquinaDAO extends maquina{
		private $connect;
		private $result = "";
		private $table = "maquina";
		private $maquina;
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
			$maquina = new maquina();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
				$maquina->setid($obj["id"]);
				$maquina->setmodel($obj["model"]);
				$maquina->setos($obj["os"]);
			}
			$this->maquina = array($maquina->getid(),$maquina->getmodel(),$maquina->getos());
				return true;
			} else {
				return false;
			}
		}
		public function countMAQ(){
			$maquina = new maquina();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			return $count;
		}
		
		public function getEveryThing(){
			$maquina = new maquina();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$maquina->setid($obj["id"]);
					$maquina->setmodel($obj["model"]);
					$maquina->setos($obj["os"]);
					array_push($result, array($maquina->getid(),$maquina->getmodel(),$maquina->getos()));
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function insertMaquina($model, $os){
			$maquina = new maquina();
			$sql = "INSERT INTO $this->table (id, model, os) VALUES (NULL, '$model', '$os')";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function deleteMaquina($query){
			$maquina = new maquina();
			$sql = "DELETE FROM $this->table WHERE $query";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function updateMaquina($targetId, $model, $os){
			$maquina = new maquina();
			$sql = "UPDATE $this->table SET model = '$model', os = '$os' WHERE $this->table.id = '$targetId'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function getMAQname($id){
			$maquina = new maquina();
			$sql = "SELECT model FROM $this->table WHERE id = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
					$maquina->setmodel($obj["model"]);
					$result = $maquina->getmodel();
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function getmaquina(){
			return $this->maquina;
		}
		public function setmaquina($maquina){
			$this->maquina = $maquina;
		}
	}

?>