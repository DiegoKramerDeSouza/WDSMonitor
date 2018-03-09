<?php
	if(session_id() == '') {
		session_start();
	}
	require_once "./class/DAO/connect.php";
	require_once "./class/DAO/operacaoDAO.php";
	require_once "./class/DAO/operacaodataDAO.php";
	require_once "./class/DAO/imagemDAO.php";
	require_once "./class/DAO/imagemdataDAO.php";
	require_once "./class/DAO/maquinaDAO.php";
	require_once "./class/DAO/cicloDAO.php";
	require_once "./class/DAO/ciclodataDAO.php";
	
	global $ldapConnection;
	global $ldapBind;
	global $operacaoDAO;
	global $operacaodataDAO;
	global $imagemDAO;
	global $imagemdataDAO;
	global $maquinaDAO;
	global $cicloDAO;
	global $ciclodataDAO;
	
	$operacaoDAO = new operacaoDAO();
	$operacaodataDAO = new operacaodataDAO();
	$imagemDAO = new imagemDAO();
	$imagemdataDAO = new imagemdataDAO();
	$maquinaDAO = new maquinaDAO();
	$cicloDAO = new cicloDAO();
	$ciclodataDAO = new ciclodataDAO();
	
	function getcount(){
		global $operacaoDAO;
		global $imagemDAO;
		global $maquinaDAO;
		global $cicloDAO;
		
		$countOPE = $operacaoDAO->countOPE();
		$countMAQ = $maquinaDAO->countMAQ();
		$countIMG = $imagemDAO->countIMG();
		$countCIC = $cicloDAO->countCIC();
		$result = array("OPE"=>$countOPE,"MAQ"=>$countMAQ,"IMG"=>$countIMG,"CIC"=>$countCIC);
		return $result;
	}
	
	function ldapConnect(){
		global $ldapConnection;
		global $ldapBind;
		
		$login = $_SESSION['matricula'];
		//Dados de Conexão LDAP================================================================================
		//Usuário de conexão
		$ldapU = "call\\" . $login;
		//Senha de conexão
		$ldapPw = base64_decode($_SESSION['senha']);
		//Caminho - OU
		$base = "DC=call,DC=br";
		//Host de conexão
		$ldapH = "LDAP://SVDF07W000119.call.br";
		//Porta de conexão
		$ldapP = "389";
		//=====================================================================================================
			
		//Estabelece conexão com LDAP
			$ldapConnection = ldap_connect($ldapH, $ldapP);
			ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);
			
			if($ldapConnection){
				//Executa Binding de conta LDAP
				$ldapBind = ldap_bind($ldapConnection, $ldapU, $ldapPw);
			}
	}
	
	function getOU($database){
		global $ldapBind, $ldapConnection;
		
		ldapConnect();
		$countDatabase = explode(",", $database);
		$dbView = $database;
		$filter = '(&(objectClass=OrganizationalUnit))';
		$OUs = array();
		if($ldapBind){
			//Search
			$sr = ldap_search($ldapConnection, $dbView, $filter);
			//Organiza
			$sort = ldap_sort($ldapConnection, $sr, 'name');
			//Recolhe entradas
			$info = ldap_get_entries($ldapConnection, $sr);
		}
		for ($i = 0; $i < $info["count"]; $i++) {
			$rest = substr($info[$i]["distinguishedname"][0], 2);
			$thisCount = explode(",", $info[$i]["distinguishedname"][0]);
			if(count($thisCount) == (count($countDatabase) + 1)){
				array_push($OUs, $info[$i]["name"][0] . "|" . $info[$i]["distinguishedname"][0]);
			}
		}
		return $OUs;
	}
	
	function getAdComputers($database){
		global $ldapBind, $ldapConnection;
		
		ldapConnect();
		$dbView = $database;
		$filter = '(&(objectClass=Computer))';
		$machineData = array();
		if($ldapBind){
			//Search
			$sr = ldap_search($ldapConnection, $dbView, $filter);
			//Organiza
			$sort = ldap_sort($ldapConnection, $sr, 'name');
			//Recolhe entradas
			$info = ldap_get_entries($ldapConnection, $sr);
		}
		for ($i = 0; $i < $info["count"]; $i++) {
			if(isset($info[$i]["extensionattribute2"][0])){
				if($info[$i]["extensionattribute2"][0] != ""){
					$result = array("iswds"=>"WDS","name"=>$info[$i]["name"][0],"dn"=>$info[$i]["distinguishedname"][0],"image"=>$info[$i]["extensionattribute2"][0]);
				} else {
					$result = array("iswds"=>"NO","name"=>$info[$i]["name"][0],"dn"=>$info[$i]["distinguishedname"][0],"image"=>$info[$i]["extensionattribute2"][0]);
				}
			} else {
				$result = array("iswds"=>"NO","name"=>$info[$i]["name"][0],"dn"=>$info[$i]["distinguishedname"][0],"image"=>"NOIMAGE");
			}
			array_push($machineData, $result);
		}
		return $machineData;
	}
	
	function getOS(){
		global $ldapBind, $ldapConnection;
		if(file_exists("./logs/computers/computers.mddb")){
			$file = file_get_contents("./logs/computers/computers.mddb");
			$file = utf8_decode($file);
			$lines = explode("#", $file);
			$os = array();
			foreach($lines as $line){
				$content = explode("|", $line);
				if(isset($content[1]) && isset($content[3])){
					$data = $content[1];
					array_push($os, $data);
				}
			}
			$computers = array_unique($os);
		} else {
			$computers = null;
		}
		return $computers;
	}
	
	function getAllData($name){
		global $operacaoDAO;
		global $operacaodataDAO;
		global $imagemDAO;
		global $imagemdataDAO;
		global $maquinaDAO;
		global $cicloDAO;
		global $ciclodataDAO;
		if($name == "operacao"){
			$index = $operacaoDAO->getEveryThing();
		} elseif($name == "operacaodata"){
			$index = $operacaodataDAO->getEveryThing();
		} elseif($name == "imagem"){
			$index = $imagemDAO->getEveryThing();
		} elseif($name == "imagemdata"){
			$index = $imagemdataDAO->getEveryThing();
		} elseif($name == "maquina"){
			$index = $maquinaDAO->getEveryThing();
		}  elseif($name == "ciclo"){
			$index = $cicloDAO->getEveryThing();
		}  elseif($name == "ciclodata"){
			$index = $ciclodataDAO->getEveryThing();
		}
		return $index;
	}
	
	function  getAllImgBySetor($setor){
		global $imagemDAO;
		$index = $imagemDAO->getDataBySetor($setor);
		return $index;
	}
	function  getAllImgDataBySetor($setor){
		global $imagemdataDAO;
		$index = $imagemdataDAO->getDataBySetor($setor);
		return $index;
	}
	function  getAllOpeDNBySetor($idsetor){
		global $operacaodataDAO;
		$index = $operacaodataDAO->getOPEDataBySetor($idsetor);
		return $index;
	}
	
	//===============================================================
	//Setor
	//===============================================================
	function newSetor($name, $dn, $desc){
		global $operacaoDAO;
		global $operacaodataDAO;
		$datetime = dateTime();
		$name = utf8_decode($name);
		$desc = utf8_decode($desc);
		$creation = $_SESSION['name'] . "|" . $datetime;
		$insertSetor = $operacaoDAO->insertOPE($name);
		if($insertSetor != false){
			$insertSetorData = $operacaodataDAO->insertOPEdata($insertSetor, $desc, $creation, $dn);
		} else {
			$insertSetorData = false;
		}
		return $insertSetorData;
	}
	
	function deleteSetor($id){
		global $operacaoDAO;
		global $operacaodataDAO;
		$index = false;
		$indexB = $operacaodataDAO->deleteOPEdata("Operacao_id = '$id'");
		$indexA = $operacaoDAO->deleteOPE("id = '$id'");
		if($indexA && $indexB){
			$index = true;
		}
		return $index;
	}
	
	function updateSetor($id, $name, $dn, $desc){
		global $operacaoDAO;
		global $operacaodataDAO;
		$datetime = dateTime();
		$name = utf8_decode($name);
		$desc = utf8_decode($desc);
		$creation = $_SESSION['name'] . "|" . $datetime;
		$updateSetor = $operacaoDAO->updateOPE($id, $name);
		if($updateSetor != false){
			$updateSetorData = $operacaodataDAO->updateOPEdata($id, $desc, $creation, $dn);
		} else {
			$updateSetorData = false;
		}
		return $updateSetorData;
	}	
	//===============================================================

	//===============================================================
	//Hardware
	//===============================================================
	function newHdw($name, $os){
		global $maquinaDAO;
		$name = utf8_decode($name);
		$insertHDW = $maquinaDAO->insertMaquina($name, $os);
		return $insertHDW;
	}
	
	function deleteHdw($id){
		global $maquinaDAO;
		$index = false;
		$index = $maquinaDAO->deleteMaquina("id = '$id'");
		return $index;
	}
	
	function updateHdw($id, $name, $os){
		global $maquinaDAO;
		$name = utf8_decode($name);
		$updateHdw = $maquinaDAO->updateMaquina($id, $name, $os);
		return $updateHdw;
	}
	//===============================================================
	
	//===============================================================
	//Imagem
	//===============================================================
	function collectSetor($imgsetorId){
		global $operacaoDAO;
		$result = $operacaoDAO->getOPEname($imgsetorId);
		return $result;
	}
	function collectHdw($imghdwId){
		global $maquinaDAO;
		$result = $maquinaDAO->getMAQname($imghdwId);
		return $result;
	}
	function newImagem($idsetor, $idhdw, $name, $version, $desc){
		global $imagemDAO;
		global $imagemdataDAO;
		$name = utf8_decode($name);
		$desc = utf8_decode($desc);
		$creator = $_SESSION['name'];
		$insertImagem = $imagemDAO->insertIMG($idsetor, $idhdw, $name);
		if($insertImagem != false){
			$insertImagemData = $imagemdataDAO->insertIMGdata($idsetor, $idhdw, $version, $desc, $creator);
		} else {
			$insertImagemData = false;
		}
		return $insertImagemData;
	}
	
	function deleteImagem($id, $setorid, $hdwid){
		global $imagemDAO;
		global $imagemdataDAO;
		$index = false;
		$indexA = $imagemdataDAO->deleteIMGdata("id = '$id'");
		if($indexA != false){
			$index = $imagemDAO->deleteIMG("operacao_id = '$setorid' AND maquina_id = '$hdwid'");
		} else {
			$index = false;
		}
		return $index;
	}

	function updateImagem($id, $name, $setorid, $hdwid, $newsetorid, $newhdwid, $version, $desc){
		global $imagemDAO;
		global $imagemdataDAO;
		$name = utf8_decode($name);
		$desc = utf8_decode($desc);
		$updateImagem = $imagemdataDAO->updateIMGdata($id, $newsetorid, $newhdwid, $version, $desc);
		if($updateImagem != false){
			$updateImagemData = $imagemDAO->updateIMG($newsetorid, $newhdwid, $setorid, $hdwid, $name);
		} else {
			$updateImagemData = false;
		}
		return $updateImagemData;
	}
	//===============================================================
	
	//===============================================================
	//Ciclo
	//===============================================================
	function collectImagem($cicsetorId, $cichdwId){
		global $imagemDAO;
		$result = $imagemDAO->getIMGname($cicsetorId, $cichdwId);
		return $result;
	}
	function newCiclo($name, $setor, $imgs, $desc, $start, $end){
		global $cicloDAO;
		global $ciclodataDAO;
		$name = utf8_decode($name);
		$desc = utf8_decode($desc);
		$creator = $_SESSION['name'];
		$insertCiclo = $cicloDAO->insertCIC($setor, $name);
		if($insertCiclo != false){
			$insertCicloData = $ciclodataDAO->insertCICdata($insertCiclo, $imgs, $start, $end, $desc);
		} else {
			$insertCicloData = false;
		}
		return $insertCicloData;
	}
	
	function deleteCiclo($id, $dataid){
		global $cicloDAO;
		global $ciclodataDAO;
		$index = false;
		$indexA = $ciclodataDAO->deleteCICdata("id = '$dataid'");
		if($indexA != false){
			$index = $cicloDAO->deleteCIC("id = '$id'");
		} else {
			$index = false;
		}
		return $index;
	}

	function updateCiclo($id, $dataid, $name, $setorid, $imgid, $start, $end, $desc){
		global $cicloDAO;
		global $ciclodataDAO;
		$name = utf8_decode($name);
		$desc = utf8_decode($desc);
		$updateCiclo = $ciclodataDAO->updateCICdata($dataid, $id, $imgid, $start, $end, $desc);
		if($updateCiclo != false){
			$updateCicloData = $cicloDAO->updateCIC($id, $setorid, $name);
		} else {
			$updateCicloData = false;
		}
		return $updateCicloData;
	}
	//===============================================================
	
	function dateTime(){
		//Set time zone
		date_default_timezone_set("America/Sao_Paulo");
		
		//Data/Hora Atual
		$data = getdate();
		$mesPadrao = 31;
		
		$horas = $data["hours"];
		$minutos = $data["minutes"];
		$dias = $data["mday"];
		$meses = $data["mon"];
		$anos = $data["year"];
		if(strlen($horas) == 1){
			$horas = "0" . $horas;
		}
		if(strlen($minutos) == 1){
			$minutos = "0" . $minutos;
		}
		if(strlen($dias) == 1){
			$dias = "0" . $dias;
		}
		if(strlen($meses) == 1){
			$meses = "0" . $meses;
		}
		
		$dataAtual = $horas . ":" . $minutos . "|" . $dias . "-" . $meses . "-" . $anos;
		return $dataAtual;
	}
	
	
	

?>