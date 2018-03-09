<?php 
	class imagemdata{
		private $id;
		private $ImagemOperacaoid;
		private $ImagemMaquinaid;
		private $version;
		private $description;
		private $creator;
		
		public function getid(){
			return $this->id;
		}
		public function setid($id){
			$this->id = $id;
		}
		public function getImagemOperacaoid(){
			return $this->ImagemOperacaoid;
		}
		public function setImagemOperacaoid($ImagemOperacaoid){
			$this->ImagemOperacaoid = $ImagemOperacaoid;
		}
		public function getImagemMaquinaid(){
			return $this->ImagemMaquinaid;
		}
		public function setImagemMaquinaid($ImagemMaquinaid){
			$this->ImagemMaquinaid = $ImagemMaquinaid;
		}
		public function getversion(){
			return $this->version;
		}
		public function setversion($version){
			$this->version = $version;
		}
		public function getdescription(){
			return $this->description;
		}
		public function setdescription($description){
			$this->description = $description;
		}
		public function getcreator(){
			return $this->creator;
		}
		public function setcreator($creator){
			$this->creator = $creator;
		}

	}
?>