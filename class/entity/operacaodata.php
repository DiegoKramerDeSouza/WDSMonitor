<?php 
	class operacaodata{
		private $id;
		private $Operacao_id;
		private $description;
		private $creation;
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
		public function getdescription(){
			return $this->description;
		}
		public function setdescription($description){
			$this->description = $description;
		}
		public function getcreation(){
			return $this->creation;
		}
		public function setcreation($creation){
			$this->creation = $creation;
		}
		public function getdn(){
			return $this->dn;
		}
		public function setdn($dn){
			$this->dn = $dn;
		}
		

	}
?>