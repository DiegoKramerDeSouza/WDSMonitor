<?php
	if(session_id() == '') {
		session_start();
	}
	require_once "functions.php";
	
	if (isset($_POST['user']) && isset($_POST['password'])){
		$_SESSION['matricula'] = strtolower($_POST['user']);
		$_SESSION['senha'] = base64_encode($_POST['password']);
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
			$ldapConnection = ldap_connect($ldapH, $ldapP) or die (header("Location:login.php?erro=1"));
			ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);
			
			if($ldapConnection){
				//Executa Binding de conta LDAP
				$ldapBind = ldap_bind($ldapConnection, $ldapU, $ldapPw) or die (header("Location:login.php?erro=2"));
			} else {
				$_SESSION['active'] = 0;
				header("location:login.php?erro=0");
			}
			if($ldapBind){
				$filter = '(&(objectClass=User)(sAMAccountname=' . $login . '))';
				//Search
				$search = ldap_search($ldapConnection, "DC=call,DC=br", $filter);
				//Recolhe entradas
				$info = ldap_get_entries($ldapConnection, $search);
				
				if (isset($info[0]["displayname"][0])){
					$name = $info[0]["displayname"][0];
				}
				$member = "";
				if (isset($info[0]["memberof"][0])){
					$member = $info[0]["memberof"];
				}
				
				//Get photo--------------------
				if (isset($info[0]["thumbnailphoto"])){
					$photo = $info[0]["thumbnailphoto"][0];
					$tumbphoto = "<img src='data:image/jpeg;base64," . base64_encode($photo) . "' style='width:80px; height:80px; border-radius:40px;' />";
					$photo = "<img src='data:image/jpeg;base64," . base64_encode($photo) . "' />";
				} else {
					$photo = "<img src='img/user_icon.png'>";
					$tumbphoto = "<img src='img/user_icon.png' style='width:80px; height:80px; border-radius:40px;' />";
				}
				if(isset($name)){
					$_SESSION['name'] = utf8_decode($name);
					$_SESSION['photo'] = $photo;
					$_SESSION['tumbphoto'] = $tumbphoto;
					$_SESSION['myInfo'] = "#" . base64_encode("Initiate data") . "|" . base64_encode($name) . "|" . base64_encode($_SESSION['matricula']) . "|" . base64_encode($_SESSION['senha']) . "|" . base64_encode("End data");
					$_SESSION['myInfo'] = base64_encode($_SESSION['myInfo']);
					$_SESSION['active'] = 1;
					$_SESSION['wdsmonitor'] = true;
					$_SESSION['groupMember'] = false;
					foreach($member as $group){
						$groupName = explode(",", $group, 2);
						if($groupName[0] == "CN=G.ACESSO.WDSMONITOR"){
							$_SESSION['groupMember'] = true;
						}
					}
										
					ldap_close($ldapConnection);				
					header("Location:index.php");
				} else {
					$_SESSION['active'] = 0;
					header("Location:logout.php");
					exit();
				}
			} else {
				$_SESSION['active'] = 0;
				header("Location:logout.php");
				exit();
			}
		//==========================================================================================================
	} else {
		$_SESSION['active'] = 0;
		header("location:login.php?erro=0");
	}
	
?>