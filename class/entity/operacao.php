<?php 
	class operacao{
		private $id;
		private $name;

		public function getid(){
			return $this->id;
		}
		public function setid($id){
			$this->id = $id;
		}
		public function getname(){
			return $this->name;
		}
		public function setname($name){
			$this->name = $name;
		}

	}
?>