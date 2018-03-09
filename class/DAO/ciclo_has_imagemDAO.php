<?php 
	require_once './class/entity/ciclo_has_imagem.php';
	class ciclo_has_imagemDAO extends ciclo_has_imagem{
		private $connect;
		private $result = "";
		private $table = "ciclo_has_imagem";
		private $ciclo_has_imagem;
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
			$ciclo_has_imagem = new ciclo_has_imagem();
			$sql = "SELECT * FROM $this->table WHERE $where = '$id'";
			$exec = mysqli_query($this->connect->getCon(), $sql);
			$count = $exec->num_rows;
			if($count > 0){
				while($obj = $exec->fetch_assoc()){
				$ciclo_has_imagem->setCiclo_id($obj["Ciclo_id"]);
				$ciclo_has_imagem->setImagem_Maquina_id($obj["Imagem_Maquina_id"]);
				$ciclo_has_imagem->setImagem_Operacao_id($obj["Imagem_Operacao_id"]);
			}
			$this->ciclo_has_imagem = array($ciclo_has_imagem->getCiclo_id(),$ciclo_has_imagem->getImagem_Maquina_id(),$ciclo_has_imagem->getImagem_Operacao_id());
				return true;
			} else {
				return false;
			}
		}
		public function getciclo_has_imagem(){
			return $this->ciclo_has_imagem;
		}
		public function setciclo_has_imagem($ciclo_has_imagem){
			$this->ciclo_has_imagem = $ciclo_has_imagem;
		}
	}

?>