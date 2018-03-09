<?php 
	class maquina{
		private $id;
		private $model;
		private $os;
		public function getid(){
			return $this->id;
		}
		public function setid($id){
			$this->id = $id;
		}
		public function getmodel(){
			return $this->model;
		}
		public function setmodel($model){
			$this->model = $model;
		}
		public function getos(){
			return $this->os;
		}
		public function setos($os){
			$this->os = $os;
		}

	}
?>