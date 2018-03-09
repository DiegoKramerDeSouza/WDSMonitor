<?php 
	require_once './class/entity/operacaodata.php';
	class operacaodataDAO extends operacaodata{
		private $connect;
		private $result = "";
		private $table = "operacaodata";
		private $operacaodata;
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
			$operacaodata = new operacaodata();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
					$operacaodata->setid($obj["id"]);
					$operacaodata->setOperacao_id($obj["Operacao_id"]);
					$operacaodata->setdescription($obj["description"]);
					$operacaodata->setcreation($obj["creation"]);
					$operacaodata->setdn($obj["dn"]);
				}
				$this->operacaodata = array($operacaodata->getid(),$operacaodata->getOperacao_id(),$operacaodata->getdescription(),$operacaodata->getcreation(),$operacaodata->getdn());
				return true;
			} else {
				return false;
			}
		}
		
		public function getEveryThing(){
			$operacaodata = new operacaodata();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$operacaodata->setid($obj["id"]);
					$operacaodata->setOperacao_id($obj["Operacao_id"]);
					$operacaodata->setdescription($obj["description"]);
					$operacaodata->setcreation($obj["creation"]);
					$operacaodata->setdn($obj["dn"]);
					array_push($result, array($operacaodata->getid(),$operacaodata->getOperacao_id(),$operacaodata->getdescription(),$operacaodata->getcreation(),$operacaodata->getdn()));
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function getOPEDataBySetor($setor){
			$operacaodata = new operacaodata();
			$sql = "SELECT * FROM $this->table WHERE $this->table.Operacao_id = '$setor'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$operacaodata->setid($obj["id"]);
					$operacaodata->setOperacao_id($obj["Operacao_id"]);
					$operacaodata->setdescription($obj["description"]);
					$operacaodata->setcreation($obj["creation"]);
					$operacaodata->setdn($obj["dn"]);
					array_push($result, array($operacaodata->getid(),$operacaodata->getOperacao_id(),$operacaodata->getdescription(),$operacaodata->getcreation(),$operacaodata->getdn()));
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function insertOPEdata($targetId, $desc, $creation, $dn){
			$operacaodata = new operacaodata();
			$sql = "INSERT INTO $this->table (id, Operacao_id, description, creation, dn) VALUES (NULL, '$targetId', '$desc', '$creation', '$dn')";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function deleteOPEdata($query){
			$operacaodata = new operacaodata();
			$sql = "DELETE FROM $this->table WHERE $query";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function updateOPEdata($targetId, $desc, $creation, $dn){
			$operacaodata = new operacaodata();
			$sql = "UPDATE $this->table SET description = '$desc', creation = '$creation', dn = '$dn' WHERE $this->table.Operacao_id = '$targetId'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function getoperacaodata(){
			return $this->operacaodata;
		}
		public function setoperacaodata($operacaodata){
			$this->operacaodata = $operacaodata;
		}
	}

?>