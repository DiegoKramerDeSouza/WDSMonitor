<?php 
	class ciclo{
		private $id;
		private $Operacao_id;
		private $name;
		
		public function getid(){
			return $this->id;
		}
		public function setid($id){
			$this->id = $id;
		}
		public function getOperacao_id(){
			return $this->Operacao_id;
		}
		public function setOperacao_id($Operacao_id){
			$this->Operacao_id = $Operacao_id;
		}
		public function getname(){
			return $this->name;
		}
		public function setname($name){
			$this->name = $name;
		}

	}
?>