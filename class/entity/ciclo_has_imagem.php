<?php 
	class ciclo_has_imagem{
		private $Ciclo_id;
		private $Imagem_Maquina_id;
		private $Imagem_Operacao_id;
		public function getCiclo_id(){
			return $this->Ciclo_id;
		}
		public function setCiclo_id($Ciclo_id){
			$this->Ciclo_id = $Ciclo_id;
		}
		public function getImagem_Maquina_id(){
			return $this->Imagem_Maquina_id;
		}
		public function setImagem_Maquina_id($Imagem_Maquina_id){
			$this->Imagem_Maquina_id = $Imagem_Maquina_id;
		}
		public function getImagem_Operacao_id(){
			return $this->Imagem_Operacao_id;
		}
		public function setImagem_Operacao_id($Imagem_Operacao_id){
			$this->Imagem_Operacao_id = $Imagem_Operacao_id;
		}

	}
?>