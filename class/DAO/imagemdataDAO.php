<?php 
	require_once './class/entity/imagemdata.php';
	class imagemdataDAO extends imagemdata{
		private $connect;
		private $result = "";
		private $table = "imagemdata";
		private $imagemdata;
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
			$imagemdata = new imagemdata();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
				$imagemdata->setid($obj["id"]);
				$imagemdata->setImagemOperacaoid($obj["ImagemOperacaoid"]);
				$imagemdata->setImagemMaquinaid($obj["ImagemMaquinaid"]);
				$imagemdata->setversion($obj["version"]);
				$imagemdata->setdescription($obj["description"]);
				$imagemdata->setcreator($obj["creator"]);
			}
			$this->imagemdata = array($imagemdata->getid(),$imagemdata->getImagemOperacaoid(),$imagemdata->getImagemMaquinaid(),$imagemdata->getversion(),$imagemdata->getdescription(),$imagemdata->getcreator());
				return true;
			} else {
				return false;
			}
		}
		
		public function getEveryThing(){
			$imagemdata = new imagemdata();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$imagemdata->setid($obj["id"]);
					$imagemdata->setImagemOperacaoid($obj["ImagemOperacaoid"]);
					$imagemdata->setImagemMaquinaid($obj["ImagemMaquinaid"]);
					$imagemdata->setversion($obj["version"]);
					$imagemdata->setdescription($obj["description"]);
					$imagemdata->setcreator($obj["creator"]);
					array_push($result, array($imagemdata->getid(),$imagemdata->getImagemOperacaoid(),$imagemdata->getImagemMaquinaid(),$imagemdata->getversion(),$imagemdata->getdescription(),$imagemdata->getcreator()));
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function getDataBySetor($setor){
			$imagemdata = new imagemdata();
			$sql = "SELECT * FROM $this->table WHERE ImagemOperacaoid = '$setor'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$imagemdata->setid($obj["id"]);
					$imagemdata->setImagemOperacaoid($obj["ImagemOperacaoid"]);
					$imagemdata->setImagemMaquinaid($obj["ImagemMaquinaid"]);
					$imagemdata->setversion($obj["version"]);
					$imagemdata->setdescription($obj["description"]);
					$imagemdata->setcreator($obj["creator"]);
					array_push($result, array($imagemdata->getid(),$imagemdata->getImagemOperacaoid(),$imagemdata->getImagemMaquinaid(),$imagemdata->getversion(),$imagemdata->getdescription(),$imagemdata->getcreator()));
				}
				return $result;
			} else {
				return false;
			}
		}
		
		public function insertIMGdata($opeid, $hdwid, $version, $description, $creator){
			$imagemdata = new imagemdata();
			$sql = "INSERT INTO $this->table (id, ImagemOperacaoid, ImagemMaquinaid, version, description, creator) VALUES (NULL, '$opeid', '$hdwid', '$version', '$description', '$creator')";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function deleteIMGdata($query){
			$imagemdata = new imagemdata();
			$sql = "DELETE FROM $this->table WHERE $query";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function updateIMGdata($id, $opeid, $hdwid, $version, $description){
			$imagemdata = new imagemdata();
			$sql = "UPDATE $this->table SET ImagemOperacaoid = '$opeid', ImagemMaquinaid = '$hdwid', version = '$version', description = '$description' WHERE $this->table.id = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $sql;
		}
		
		public function getimagemdata(){
			return $this->imagemdata;
		}
		public function setimagemdata($imagemdata){
			$this->imagemdata = $imagemdata;
		}
	}

?>