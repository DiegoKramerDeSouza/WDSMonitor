<?php 
	class ciclodata{
		private $id;
		private $Ciclo_id;
		private $images;
		private $start;
		private $finish;
		private $description;
		
		public function getid(){
			return $this->id;
		}
		public function setid($id){
			$this->id = $id;
		}
		public function getCiclo_id(){
			return $this->Ciclo_id;
		}
		public function setCiclo_id($Ciclo_id){
			$this->Ciclo_id = $Ciclo_id;
		}
		public function getimages(){
			return $this->images;
		}
		public function setimages($images){
			$this->images = $images;
		}
		public function getstart(){
			return $this->start;
		}
		public function setstart($start){
			$this->start = $start;
		}
		public function getfinish(){
			return $this->finish;
		}
		public function setfinish($finish){
			$this->finish = $finish;
		}
		public function getdescription(){
			return $this->description;
		}
		public function setdescription($description){
			$this->description = $description;
		}

	}
?>