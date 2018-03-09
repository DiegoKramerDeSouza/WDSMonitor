<?php 
	class imagem{
		private $Operacao_id;
		private $Maquina_id;
		private $name;
		
		public function getOperacao_id(){
			return $this->Operacao_id;
		}
		public function setOperacao_id($Operacao_id){
			$this->Operacao_id = $Operacao_id;
		}
		public function getMaquina_id(){
			return $this->Maquina_id;
		}
		public function setMaquina_id($Maquina_id){
			$this->Maquina_id = $Maquina_id;
		}
		public function getname(){
			return $this->name;
		}
		public function setname($name){
			$this->name = $name;
		}

	}
?>