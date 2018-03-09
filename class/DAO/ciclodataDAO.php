<?php 
	require_once './class/entity/ciclodata.php';
	class ciclodataDAO extends ciclodata{
		private $connect;
		private $result = "";
		private $table = "ciclodata";
		private $ciclodata;
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
			$ciclodata = new ciclodata();
			$sql = "SELECT * FROM $this->table";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				$result = array();
				while($obj = $exec->fetch_assoc()){
					$ciclodata->setid($obj["id"]);
					$ciclodata->setCiclo_id($obj["Ciclo_id"]);
					$ciclodata->setimages($obj["images"]);
					$ciclodata->setstart($obj["start"]);
					$ciclodata->setfinish($obj["finish"]);
					$ciclodata->setdescription($obj["description"]);
					array_push($result, array($ciclodata->getid(),$ciclodata->getCiclo_id(),$ciclodata->getimages(),$ciclodata->getstart(),$ciclodata->getfinish(),$ciclodata->getdescription()));
				}
				return $result;
			} else {
				return false;
			}
		}
		public function setAll($id, $where){
			$ciclodata = new ciclodata();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
				$ciclodata->setid($obj["id"]);
				$ciclodata->setCiclo_id($obj["Ciclo_id"]);
				$ciclodata->setimages($obj["images"]);
				$ciclodata->setstart($obj["start"]);
				$ciclodata->setfinish($obj["finish"]);
				$ciclodata->setdescription($obj["description"]);
			}
			$this->ciclodata = array($ciclodata->getid(),$ciclodata->getCiclo_id(),$ciclodata->getimages(),$ciclodata->getstart(),$ciclodata->getfinish(),$ciclodata->getdescription());
				return true;
			} else {
				return false;
			}
		}
		public function insertCICdata($cicloid, $images, $start, $end, $desc){
			$ciclodata = new ciclodata();
			$sql = "INSERT INTO $this->table (id, Ciclo_id, images, start, finish, description) VALUES (NULL, '$cicloid', '$images', '$start', '$end', '$desc')";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		public function deleteCICdata($query){
			$ciclodata = new ciclodata();
			$sql = "DELETE FROM $this->table WHERE $query";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		public function updateCICdata($dataid, $id, $imgid, $start, $end, $desc){
			$ciclodata = new ciclodata();
			$sql = "UPDATE $this->table SET images = '$imgid', start = '$start', finish = '$end', description = '$desc' WHERE $this->table.id = '$dataid'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			return $exec;
		}
		
		public function getciclodata(){
			return $this->ciclodata;
		}
		public function setciclodata($ciclodata){
			$this->ciclodata = $ciclodata;
		}
	}

?>