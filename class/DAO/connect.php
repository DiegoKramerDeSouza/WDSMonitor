<?php
	require_once 'conf.php';
	class connect{
		private $user = STRUSER;
		private $password = STRPASS;
		private $banco = STRDB;
		private $path = STRPATH;
		private $con;
		private $ac;
		private $account;
		private $ps;
		private $key;
		public function __construct(){
			$this->ac = explode("|", $this->user);
			$this->ps = explode("|", $this->password);
			$this->account = base64_decode($this->ac[1]);
			$this->account = explode("::",$this->account);
			$this->key = base64_decode($this->ps[1]);
			$this->key = explode("::", $this->key);
			$this->con = mysqli_connect($this->path, $this->account[3], $this->key[3]) or die ("Falha ao conectar!");
			mysqli_select_db($this->con, $this->banco) or die ("Não foi possível conectar à base!");
		}
		public function getCon(){
			return $this->con;
		}
	}
?>