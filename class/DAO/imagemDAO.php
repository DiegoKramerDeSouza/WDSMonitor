<?php 
	require_once './class/entity/imagem.php';
	class imagemDAO extends imagem{
		private $connect;
		private $result = "";
		private $table = "imagem";
		private $imagem;
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
			$imagem = new imagem();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
				$imagem->setOperacao_id($obj["Operacao_id"]);
				$imagem->setMaquina_id($obj["Maquina_id"]);
				$imagem->setname($obj["name"]);
			}
			$this->imagem = array($imagem->getOperacao_id(),$imagem->getMaquina_id(),$imagem->getname());
			return true;
			} else {
				return false;
			}
		}
		public function countIMG(){
			$imagem = new imagem();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			return $count;
		}
		
		public function getEveryThing(){
			$imagem = new imagem();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$imagem->setOperacao_id($obj["Operacao_id"]);
					$imagem->setMaquina_id($obj["Maquina_id"]);
					$imagem->setname($obj["name"]);
					array_push($result, array($imagem->getOperacao_id(),$imagem->getMaquina_id(),$imagem->getname()));
				}
				return $result;
			} else {
				return false;
			}
		}
		public function getSomeThing($id, $where){
			$imagem = new imagem();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$imagem->setOperacao_id($obj["Operacao_id"]);
					$imagem->setMaquina_id($obj["Maquina_id"]);
					$imagem->setname($obj["name"]);
					array_push($result, array($imagem->getOperacao_id(),$imagem->getMaquina_id(),$imagem->getname()));
				}
				return $result;
			} else {
				return false;
			}
		}
		public function getDataBySetor($setor){
			$imagem = new imagem();
			$sql = "SELECT * FROM $this->table WHERE Operacao_id = '$setor'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$imagem->setOperacao_id($obj["Operacao_id"]);
					$imagem->setMaquina_id($obj["Maquina_id"]);
					$imagem->setname($obj["name"]);
					array_push($result, array($imagem->getOperacao_id(),$imagem->getMaquina_id(),$imagem->getname()));
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function insertIMG($opeid, $hdwid, $name){
			$imagem = new imagem();
			$sql = "INSERT INTO $this->table (Operacao_id, Maquina_id, name) VALUES ('$opeid', '$hdwid', '$name')";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function deleteIMG($query){
			$imagem = new imagem();
			$sql = "DELETE FROM $this->table WHERE $query";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}

		public function updateIMG($newopeid, $newhdwid, $opeid, $hdwid, $name){
			$imagem = new imagem();
			$sql = "UPDATE $this->table SET Operacao_id = '$newopeid', Maquina_id = '$newhdwid', name = '$name' WHERE $this->table.Operacao_id = '$opeid' AND $this->table.maquina_id = '$hdwid'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function getIMGname($idOPE, $idMAQ){
			$imagem = new imagem();
			$sql = "SELECT name FROM $this->table WHERE Operacao_id = '$idOPE' AND Maquina_id = '$idMAQ'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
					$imagem->setname($obj["name"]);
					$result = $imagem->getname();
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function getimagem(){
			return $this->imagem;
		}
		public function setimagem($imagem){
			$this->imagem = $imagem;
		}
	}

?>