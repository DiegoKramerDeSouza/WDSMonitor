<?php
	if(session_id() == '') {
		session_start();
	}
	require_once "functions.php";
	
	if(isset($_POST['page']) && isset($_POST['target'])){
		if($_POST['page'] == "gerenciar" && $_POST['target'] == "operacoes"){
			$countAll = getcount();
			$operacoes = $countAll["OPE"];
			
			$html = "<h3 class='green-text text-darken-3'><span class='fa fa-cube'></span> <b>Setores</b></h3>".
					"<div class='divider'></div>".
					"<p class='grey-text'>".
						"Crie novos setores e operações ou edite algum existente.";
					if($_SESSION['groupMember']){	
						$html = $html .
						"<span class='lg right' id='addNewSetor'><a class='grey-text' href='#!' onclick='addSetor()'><span class='light-green-text fa fa-plus-circle'></span> Adicionar Setor</a></span>";
					}
			$html = $html .		
					"</p>".
					"<div class='row' id='addOPE'>".
						"<div class='col s12'>".
							"<div class='row'>".
								"<div class='input-field col s12'>".
									"<i class='fa fa-cube fa-lg prefix green-text text-darken-3'></i>".
									"<input id='OPEname' name='OPEname' type='text' class='validade'>".
									"<label for='OPEname'>Nome do novo Setor</label>".
									"<h5 class='green-text text-darken-3'>Definições do Active Directory:</h5>".
									"<p class='grey-text'>Selecione a Unidade Organizacional onde estão os ativos do setor.</p>".
								"</div>".
								"<div class='input-field col s4 m2'>".
									"<a href='#ADdive' style='width:100%;' class='waves-effect waves-green btn green darken-3 white-text' title='Unidade Organizacional' onclick='getADstructure(\"OrganizationalUnit\", \"DC=call,DC=br\", \"OPEdn\")' title='Seleciona OU'><i class='fa fa-folder-o'></i></a>".
								"</div>".
								"<div class='input-field col s8 m10'>".
									"<input id='OPEdnName' name='OPEdnName' class='green-text text-darken-3' readonly type='text' class='validade' placeholder='Unidade Organizacional'>".
									"<input id='OPEdn' name='OPEdn' class='green-text text-darken-3' readonly type='text' class='validade' placeholder='Caminho'>".
								"</div>".
								"<div class='input-field col s12'>".
									"<i class='fa fa-commenting-o fa-lg prefix green-text text-darken-3'></i>".
									"<textarea maxlength='255' id='OPEdescription' oninput='calcChar()' name='OPEdescription' class='green-text text-darken-3 materialize-textarea'></textarea>".
									"<label for='OPEdescription'>Descrição (<b>Opcional</b>) <span class='xs right' id='opedesc'><b>0/255</b></span></label>".
								"</div>".
								"<div class='input-field col s12' align='center'>".
									"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='insertSetor()' style='width:80%;'><span class='fa fa-cube'></span> Criar Setor</span>".
								"</div>".
								"<div align='center' class='grey-text' style='padding:50px;'>".
									"<span onclick='fadeNewSetor()' class='fa fa-chevron-up fa-3x hovergreen'></span>".
								"</div>".	
							"</div>".	
						"</div>".	
					"</div><br />";	
			if($operacoes <= 0){
				$html = $html .
							"<div class='red-text text-darken-4' id='listSetor' align='center'>".
								"<h4 style='padding:150px;'><span class='fa fa-times'></span> Não há Setores registrados!</h4>".
							"</div>";
			} else {
				$resultname = getAllData("operacao");
				$resultdata = getAllData("operacaodata");
				$html = $html . "<div id='listSetor'>";
				for($i = 0; $i < count($resultname); $i++){
					$setorId = $resultname[$i][0];
					$setorname = $resultname[$i][1];
					$setordesc = $resultdata[$i][2];
					$setorcreat = $resultdata[$i][3];
					$setordn = $resultdata[$i][4];
					$expDesc = explode("|", $setorcreat);
					$descName = $expDesc[0];
					$descTime = $expDesc[1];
					$descDate = str_replace("-", "/", $expDesc[2]);
					$setorcreat = $descDate . " às " . $descTime;
					$html = $html . 
									"<div id='" . $setorId . "_scard' class='col s12 m6 setorCard'>".
										"<div id='" . $setorId . "_scard_body' class='grey darken-4 space light-green-text' style='border: 1px solid rgba(12,12,0,0.5)'>".
											"<div class='card-content'>".
											
												"<span class='card-title'>".
													"<p class='truncate' title='" . $setorname . "'>".
														"<span class='fa fa-cube'></span> <b>" . $setorname . "</b>".
													"</p>".
												"</span>".
												"<p class='truncate' title='" . $setorcreat . "'>".
													"<span class='fa fa-clock-o'></span> <b>".
														"Criado: ".
														"<span class='grey-text'>" . $setorcreat . "</span>".
													"</b>".
												"</p>".
												"<p class='truncate' title='" . $descName . "'>".
													"<span class='fa fa-user'></span> <b>".
														"Por: ".
														"<span class='grey-text'>" . $descName . "</span>".
													"</b>".
												"</p>".
												"<p class='truncate'>".
													"<span class='fa fa-commenting-o'></span> <b>Descrição: </b>".
													"<span class='grey-text' title='" . $setordesc . "'><b>" . $setordesc . "</b></span>".
												"</p>".
												"<p class='truncate'>".
													"<span class='fa fa-sitemap'></span> <b>Caminho: </b>".
													"<span class='grey-text' title='" . $setordn . "'><b>" . $setordn . "</b></span>".
												"</p>".
											
											"</div>";
										
										if($_SESSION['groupMember']){
											$html = $html . 	
												"<div class='card-action' align='right' style='padding:5px;'>".
													"<a href='#!' onclick='editSetor(\"" . $setorId . "_scard\", \"" . $setorId . "\", \"" . $setorname . "\", \"" . base64_encode($setordesc) . "\", \"" . base64_encode($setordn) . "\")'>".
														"<span class='fa fa-edit fa-lg light-green-text' title='Editar Setor'></span>".
													"</a>".
													"<a href='#!' onclick='deleteSetor(\"" . $setorId . "\")'>".
														"<span class='fa fa-times fa-lg red-text text-darken-3' title='Deletar Setor'></span>".
													"</a>".
												"</div>";
										}
											
										$html = $html . 	
										"</div>".
									"</div>";
				}
				$html = $html . "</div>";
			}
			echo utf8_encode($html);
		} elseif($_POST['page'] == "gerenciar" && $_POST['target'] == "hardware"){
			$countAll = getcount();
			$hardware = $countAll["MAQ"];
			$computers = getOS();
			
			$html = "<h3 class='green-text text-darken-3'><span class='fa fa-hdd-o'></span> <b>Hardware</b></h3>".
					"<div class='divider'></div>".
					"<p class='grey-text'>".
						"Configure novos hardwares ou edite algum existente.";
			if($_SESSION['groupMember']){
				$html = $html .
						"<span class='lg right' id='addNewHdw'><a class='grey-text' href='#!' onclick='addHdw()'><span class='light-green-text fa fa-plus-circle'></span> Adicionar Hardware</a></span>";
			}
			$html = $html .
					"</p>".
					"<div class='row' id='addHDW'>".
						"<div class='col s12'>".
							"<div class='row'>".
								"<div class='input-field col s12'>".
									"<i class='fa fa-hdd-o fa-lg prefix green-text text-darken-3'></i>".
									"<input id='HDWname' name='HDWname' type='text' class='validade' maxlength='50'>".
									"<label for='HDWname'>Modelo</label>".
								"</div>".
								"<div class='input-field col s12'>".
									"<i class='fa fa-windows fa-lg prefix green-text text-darken-3'></i>".
									"<select id='HDWos' name='HDWos'>".
										"<option value='' disabled selected>Selecione o Sistema Operacional</option>";
										if($computers != null){
											sort($computers);
											foreach($computers as $os){
												$osVal = str_replace("\0", "", $os);
												$osVal = str_replace(" ", "-", $osVal);
												$osVal = str_replace(".", "_", $osVal);
												$html = $html.
												"<option value='" . $osVal . "'>" . $os . "</option>";
											}
										}									
									$html = $html.						
									"</select>".
									"<label for='HDWos'>Sistema Operacional</label>".
								"</div>".
								"<div class='input-field col s12' align='center'>".
									"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='insertHardware()' style='width:80%;'><span class='fa fa-hdd-o'></span> Adicionar Hardware</span>".
								"</div>".
								"<div align='center' class='grey-text' style='padding:50px;'>".
									"<span onclick='fadeNewHdw()' class='fa fa-chevron-up fa-3x hovergreen'></span>".
								"</div>".	
							"</div>".	
						"</div>".	
					"</div><br />";	
			if($hardware <= 0){
				$html = $html .
							"<div class='red-text text-darken-4' id='listHardware' align='center'>".
								"<h4 style='padding:150px;'><span class='fa fa-times'></span> Não há Hardwares registrados!</h4>".
							"</div>";
			} else {
				$resultname = getAllData("maquina");
				$html = $html . "<div id='listHardware'>";
				for($i = 0; $i < count($resultname); $i++){
					$hdwId = $resultname[$i][0];
					$hdwname = $resultname[$i][1];
					$os = $resultname[$i][2];
					$hdwos = str_replace("-", " ", $os);
					$hdwos = str_replace("_", ".", $hdwos);
				
					$html = $html . 
								"<div id='listHardware'>".
									"<div id='" . $hdwId . "_scard' class='col s12 m6 setorCard'>".
										"<div id='" . $hdwId . "_scard_body' class='card grey darken-4 space light-green-text' style='border: 1px solid rgba(12,12,0,0.5)'>".
											"<div class='card-content'>".
											
												"<p class='truncate md green-text text-darken-2'>".
													"<span class='fa fa-hdd-o fa-lg'></span> ".
													"<span title='" . $hdwname . "'><b>" . $hdwname . "</b></span>".
												"</p>".
												"<p class='truncate'>".
													"<span class='fa fa-windows'></span> <b>Sistema Operacional: </b><br/>".
													"<span class='grey-text' title='" . $hdwos . "'><b>" . $hdwos . "</b></span>".
												"</p>".
											
											"</div>";
									if($_SESSION['groupMember']){
										$html = $html .
											"<div class='card-action' align='right' style='padding:5px;'>".
												"<a href='#!' onclick='editHdw(\"" . $hdwId . "_scard\", \"" . $hdwId . "\", \"" . $hdwname . "\", \"" . $os . "\")'>".
													"<span class='fa fa-edit fa-lg light-green-text' title='Editar Hardware'></span>".
												"</a>".
												"<a href='#!' onclick='deleteHdw(\"" . $hdwId . "\")'>".
													"<span class='fa fa-times fa-lg red-text text-darken-3' title='Deletar Hardware'></span>".
												"</a>".
											"</div>";
									}
									$html = $html .
										"</div>".
									"</div>";
				}
				$html = $html . "</div>";
			}
			echo utf8_encode($html);
		} elseif($_POST['page'] == "gerenciar" && $_POST['target'] == "imagem"){
			$countAll = getcount();
			$setores = $countAll["OPE"];
			$hardwares = $countAll["MAQ"];
			$images = $countAll["IMG"];
			
			if($setores <= 0 || $hardwares <= 0){
				$html = "<h3 class='green-text text-darken-3'><span class='fa fa-th-large'></span> <b>Imagens</b></h3>".
						"<div class='divider'></div>".
						"<p class='grey-text'>".
							"Registre novas imagens ou edite alguma existente.".
						"</p>".
						"<div class='red-text text-darken-4' id='listImagem' align='center' style='padding:100px;'>".
							"<h4><span class='fa fa-times'></span> Não há Setores ou Hardwares registrados!</h4>".
							"<br />".
							"<h5 class='grey-text'>Imagens necessitam ser vinculadas a um <span class='fa fa-cube'></span> Setor específico e também a um <span class='fa fa-hdd-o'></span> Hardware.</h5>".
						"</div>";
			} else {
				$setorData = getAllData("operacao");
				$hardwareData = getAllData("maquina");
				
				$html = "<h3 class='green-text text-darken-3'><span class='fa fa-th-large'></span> <b>Imagens</b></h3>".
						"<div class='divider'></div>".
						"<p class='grey-text'>".
							"Registre novas imagens ou edite alguma existente.";
				if($_SESSION['groupMember']){
					$html = $html .
							"<span class='lg right' id='addNewImage'><a class='grey-text' href='#!' onclick='addImg()'><span class='light-green-text fa fa-plus-circle'></span> Adicionar Imagem</a></span>";
				}
				$html = $html .
						"</p>".
						"<div class='row' id='addIMG'>".
							"<div class='col s12'>".
								"<div class='row'>".
								
									"<div class='input-field col s12'>".
										"<i class='fa fa-th-large fa-lg prefix green-text text-darken-3'></i>".
										"<input maxlength='50' id='IMGname' name='IMGname' type='text' class='validade'>".
										"<label for='IMGname'>Nome</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-book fa-lg prefix green-text text-darken-3'></i>".
										"<input maxlength='10' id='IMGversao' name='IMGversao' type='text' class='green-text text-darken-3'>".
										"<label for='IMGversao'>Versão</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-cube fa-lg prefix green-text text-darken-3'></i>".
										"<select id='IMGsetor' name='IMGsetor'>".
											"<option value='' disabled selected>Selecione o Setor vinculádo</option>";
											sort($setorData);
											foreach($setorData as $setor){
												$html = $html.
												"<option value='" . $setor[0] . "'>" . $setor[1] . "</option>";
											}
									$html = $html.
										"</select>".
										"<label for='IMGsetor'>Setor</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-hdd-o fa-lg prefix green-text text-darken-3'></i>".
										"<select id='IMGhdw' name='IMGhdw'>".
											"<option value='' disabled selected>Selecione o Hardware</option>";
											sort($hardwareData);
											foreach($hardwareData as $hdw){
												$html = $html.
												"<option value='" . $hdw[0] . "'>" . $hdw[1] . " [" . $hdw[2] . "]" . "</option>";
											}
									$html = $html.
										"</select>".
										"<label for='IMGhdw'>Hardware</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-commenting-o fa-lg prefix green-text text-darken-3'></i>".
										"<textarea maxlength='255' id='IMGdescription' oninput='calcCharIMG()' name='IMGdescription' class='green-text text-darken-3 materialize-textarea'></textarea>".
										"<label for='IMGdescription'>Descrição (<b>Opcional</b>) <span class='xs right' id='imgdesc'><b>0/255</b></span></label>".
									"</div>".
																									
									"<div class='input-field col s12' align='center'>".
										"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='insertImage()' style='width:80%;'><span class='fa fa-th-large'></span> Criar Imagem</span>".
									"</div>".
									"<div align='center' class='grey-text' style='padding:50px;'>".
										"<span onclick='fadeNewImagem()' class='fa fa-chevron-up fa-3x hovergreen'></span>".
									"</div>".	
								"</div>".	
							"</div>".	
						"</div><br />";
				}
			if($images <= 0){
				if($setores > 0 && $hardwares > 0){
					$html = $html .
							"<div class='red-text text-darken-4' id='listImagem' align='center'>".
								"<h4 style='padding:150px;'><span class='fa fa-times'></span> Não há Imagens cadastradas!</h4>".
							"</div>";
				}
			} else {
				$resultname = getAllData("imagem");
				$resultdata = getAllData("imagemdata");
				$html = $html . "<div id='listImagem'>";
				for($i = 0; $i < count($resultname); $i++){
					$imgsetorId = $resultname[$i][0];
					$imghdwId = $resultname[$i][1];
					$imgName = $resultname[$i][2];
					$imgdataId = $resultdata[$i][0];
					$imgVersion = $resultdata[$i][3];
					$imgDesc = $resultdata[$i][4];
					$imgCreator = $resultdata[$i][5];
					
					$imgsetorName = collectSetor($imgsetorId);
					$imghdwName = collectHdw($imghdwId);
					
					$html = $html . 
									"<div id='" . $imgdataId . "_scard' class='col s12 m6 setorCard'>".
										"<div id='" . $imgdataId . "_scard_body' class='card grey darken-4 space light-green-text' style='border: 1px solid rgba(12,12,0,0.5)'>".
											"<div class='card-content'>".
											
												"<span class='card-title' title='" . $imgName . "'>".
													"<p class='truncate'>".
														"<span class='fa fa-th-large'></span> <b>" . $imgName . "</b>".
													"</p>".
												"</span>".
												"<p class='truncate' title='" . $imgCreator . "'>".
													"<span class='fa fa-user'></span> <b>".
														"Criado por: ".
														"<span class='grey-text'>" . $imgCreator . "</span>".
													"</b>".
												"</p>".
												"<p class='truncate'>".
													"<span class='fa fa-cube'></span> <b>Setor: </b>".
													"<span class='grey-text' title='" . $imgsetorName . "'><b>" . $imgsetorName . "</b></span>".
												"</p>".
												"<p class='truncate'>".
													"<span class='fa fa-hdd-o'></span> <b>Hardware: </b>".
													"<span class='grey-text' title='" . $imghdwName . "'><b>" . $imghdwName . "</b></span>".
												"</p>".
												"<p class='truncate'>".
													"<span class='fa fa-commenting-o'></span> <b>Descrição: </b>".
													"<span class='grey-text' title='" . $imgDesc . "'><b>" . $imgDesc . "</b></span>".
												"</p>".
												"<p class='truncate'>".
													"<span class='fa fa-book'></span> <b>Versão: </b>".
													"<span class='grey-text' title='" . $imgVersion . "'><b>" . $imgVersion . "</b></span>".
												"</p>".
											
											"</div>";
										if($_SESSION['groupMember']){
											$html = $html .
											"<div class='card-action' align='right' style='padding:5px;'>".
												"<a href='#!' onclick='editImagem(\"" . $imgdataId . "_scard\", \"" . $imgdataId . "\", \"" . $imgsetorId . "\", \"" . $imghdwId . "\", \"" . $imgName . "\", \"" . $imgDesc . "\", \"" . $imgVersion . "\")'>".
													"<span class='fa fa-edit fa-lg green-text' title='Editar Imagem'></span>".
												"</a>".
												"<a href='#!' onclick='deleteImagem(\"" . $imgdataId . "\", \"" . $imgsetorId . "\", \"" . $imghdwId . "\")'>".
													"<span class='fa fa-times fa-lg red-text text-darken-3' title='Deletar Imagem'></span>".
												"</a>".
											"</div>";
										}
									$html = $html .
										"</div>".
									"</div>";
				}
				$html = $html . "</div>";
			}
			echo utf8_encode($html);
		} elseif($_POST['page'] == "gerenciar" && $_POST['target'] == "ciclo"){
			$countAll = getcount();
			$imagens = $countAll["IMG"];
			$ciclos = $countAll["CIC"];
			
			if($imagens <= 0){
				$html = "<h3 class='green-text text-darken-3'><span class='fa fa-table'></span> <b>Ciclos de Imagens</b></h3>".
						"<div class='divider'></div>".
						"<p class='grey-text'>".
							"Registre novos ciclos de distribuição de imagens ou edite algum existente.".
						"</p>".
						"<div class='red-text text-darken-4' id='listCiclo' align='center' style='padding:100px;'>".
							"<h4><span class='fa fa-times'></span> Não há Imagens registradas!</h4>".
							"<br />".
							"<h5 class='grey-text'>Ciclos necessitam ser vinculados a uma ou mais <span class='fa fa-th-large'></span> Imagens.</h5>".
						"</div>";
			} else {
				$imgSetor = getAllData("operacao");
				$imgData = getAllData("imagem");
				
				$html = "<h3 class='green-text text-darken-3'><span class='fa fa-table'></span> <b>Ciclos de Imagens</b></h3>".
						"<div class='divider'></div>".
						"<p class='grey-text'>".
							"Registre novos ciclos de distribuição de imagens ou edite algum existente.";
						if($_SESSION['groupMember']){
							$html = $html .
							"<span class='lg right' id='addNewCiclo'><a class='grey-text' href='#!' onclick='addCiclo()'><span class='light-green-text fa fa-plus-circle'></span> Adicionar Ciclo</a></span>";
						}
				$html = $html .
						"</p>".
						"<div class='row' id='addCIC'>".
							"<div class='col s12'>".
								"<div class='row'>".
								
									"<div class='input-field col s12'>".
										"<i class='fa fa-table fa-lg prefix green-text text-darken-3'></i>".
										"<input maxlength='50' id='CICname' name='CICname' type='text' class='validade'>".
										"<label for='CICname'>Nome</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-cube fa-lg prefix green-text text-darken-3'></i>".
										"<select id='CICsetor' name='CICsetor' onchange='collectCICimg(\"CICsetor\", \"divCICimg\")'>".
											"<option value='' disabled selected>Selecione o setor</option>";
											sort($imgSetor);
											foreach($imgSetor as $setor){
												$html = $html.
												"<option value='" . $setor[0] . "'>" . $setor[1] . "</option>";
											}
									$html = $html.
										"</select>".
										"<label for='CICsetor'>Setor</label>".
									"</div>".
									"<div class='input-field col s12' id='divCICimg'>".
										"<i class='fa fa-th-large fa-lg prefix grey-text text-darken-3'></i>".
										"<select multiple id='CICimg' name='CICimg' disabled>".
											"<option value='' disabled selected>Selecione um setor antes</option>".
										"</select>".
										"<label for='CICimg'>Imagens</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-play-circle fa-lg prefix green-text text-darken-3'></i>".
										"<input id='CICstart' name='CICstart' type='text' class='datepicker green-text text-darken-3'>".
										"<label for='CICstart'>Início</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-stop-circle fa-lg prefix green-text text-darken-3'></i>".
										"<input disabled id='CICend' name='CICend' type='text' class='datepicker green-text text-darken-3'>".
										"<label for='CICend'>Fim</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-commenting-o fa-lg prefix green-text text-darken-3'></i>".
										"<textarea maxlength='255' id='CICdescription' oninput='calcCharCIC()' name='CICdescription' class='green-text text-darken-3 materialize-textarea'></textarea>".
										"<label for='CICdescription'>Descrição (<b>Opcional</b>) <span class='xs right' id='cicdesc'><b>0/255</b></span></label>".
									"</div>".
																									
									"<div class='input-field col s12' align='center'>".
										"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='insertCiclo()' style='width:80%;'><span class='fa fa-table'></span> Registrar Ciclo</span>".
									"</div>".
									"<div align='center' class='grey-text' style='padding:50px;'>".
										"<span onclick='fadeNewCiclo()' class='fa fa-chevron-up fa-3x hovergreen'></span>".
									"</div>".	
								"</div>".	
							"</div>".	
						"</div><br />";
				}
			if($ciclos <= 0){
				if($imagens > 0){
					$html = $html .
							"<div class='red-text text-darken-4' id='listCiclo' align='center'>".
								"<h4 style='padding:150px;'><span class='fa fa-times'></span> Não há Ciclos registrados!</h4>".
							"</div>";
				}
			} else {
				$resultname = getAllData("ciclo");
				$resultdata = getAllData("ciclodata");
				$html = $html . "<div id='listCiclo'>";
				for($i = 0; $i < count($resultname); $i++){
					$cicId = $resultname[$i][0];
					$cicsetorId = $resultname[$i][1];
					$cicName = $resultname[$i][2];
					$cicdataId = $resultdata[$i][0];
					$cicdatacicId = $resultdata[$i][1];
					$cicimgs = $resultdata[$i][2];
					$cicImagens = explode(',', $cicimgs);
					$cicstart = $resultdata[$i][3];
					$cicend = $resultdata[$i][4];
					$cicdesc = $resultdata[$i][5];
					
					$cicsetorName = collectSetor($cicsetorId);
					$cicimgName = array();
					for($j = 1; $j < count($cicImagens); $j++){
						$cicData = explode('|', $cicImagens[$j], 2);
						$cicReturnName = collectImagem($cicData[0], $cicData[1]);
						array_push($cicimgName, $cicReturnName);
					}

					$html = $html . 
									"<div id='" . $cicId . "_scard' class='col s12 cicloCard'>".
										"<div id='" . $cicId . "_scard_body' class='card grey darken-4 space light-green-text' style='border: 1px solid rgba(12,12,0,0.5)'>".
											"<div class='card-content'>".
												
												"<span class='card-title'><span class='fa fa-th-large'></span> <b>" . $cicName . "</b></span>".
												"<div class='row'>".
													"<div class='col s12 m6'>".
														"<p class='truncate'>".
															"<span class='fa fa-cube'></span> <b>".
																"Aplicado ao setor: ".
																"<span class='grey-text' title='" . $cicsetorName . "'>" . $cicsetorName . "</span>".
															"</b>".
														"</p>".
														"<p class='truncate'>".
															"<span class='fa fa-play'></span> <b>Inicia: </b>".
															"<span class='grey-text' title='" . $cicstart . "'><b>" . $cicstart . "</b></span>".
														"</p>".
														"<p class='truncate'>".
															"<span class='fa fa-stop'></span> <b>Finaliza: </b>".
															"<span class='grey-text' title='" . $cicend . "'><b>" . $cicend . "</b></span>".
														"</p>".
														"<p>".
															"<span class='fa fa-commenting-o'></span> <b>Descrição: </b>".
															"<span class='grey-text' title='" . $cicdesc . "'><b>" . $cicdesc . "</b></span>".
														"</p>".
													"</div>".
													"<div class='col s12 m6'>".
														"<p class='truncate'>".
															"<span class='fa fa-th-large'></span> <b>Imagens aplicadas: </b><br />";
															foreach($cicimgName as $imgname){
																$html = $html .
																		"<span class='grey-text' title='" . $imgname . "'><span class='fa fa-clone'></span> <b>" . $imgname . "</b></span><br />";
															}
														$html = $html .	
														"</p>".
													"</div>".
												"</div>".
												
											"</div>";
											
										if($_SESSION['groupMember']){
											$html = $html .
											"<div class='card-action' align='right' style='padding:5px;'>".
												"<a href='#!' onclick='editCiclo(\"" . $cicId . "_scard\", \"" . $cicId . "\", \"" . $cicdatacicId . "\", \"" . $cicName . "\", \"" . $cicsetorId . "\", \"" . $cicstart . "\", \"" . $cicend . "\", \"" . $cicdesc . "\", \"" . $cicimgs . "\")'>".
													"<span class='fa fa-edit fa-lg light-green-text' title='Editar Ciclo'></span>".
												"</a>".
												"<a href='#!' onclick='deleteCiclo(\"" . $cicId . "\", \"" . $cicdatacicId . "\")'>".
													"<span class='fa fa-times fa-lg red-text text-darken-3' title='Deletar Ciclo'></span>".
												"</a>".
											"</div>";
										}
										$html = $html .
										"</div>".
									"</div>";
				}
				$html = $html . "</div>";
			}
			echo utf8_encode($html);
		} elseif($_POST['page'] == "monitorar" && $_POST['target'] == "setor"){
			$operacao = getAllData("operacao");
			$operacaodata = getAllData("operacaodata");
			$operacaoList = array();
			$html = "";
			for($i = 0; $i < count($operacaodata); $i++){
				$base = $operacaodata[$i][4];
				$html =	$html .
							"<div class='col s12 m6 '>" .
								"<div class='grey darken-4 green-text text-darken-1 card-panel' style='padding:10px; margin:3px;'>".
									"<div class='card-content'>".
										"<div class='col s8 m10' style='margin-top:-25px;'>".
											"<h5 class='truncate' title='" . $operacao[$i][1] . "'><span class='fa fa-cube'></span> " . $operacao[$i][1] . "</h5>".
										"</div>".
										"<div class='col s4 m2' style='margin-top:-20px;'>".
											"<a href='#' onclick='callOPEChart(\"setor\",\"" . $operacao[$i][0] . "\", \"" . $operacao[$i][1] . "\", \"" . $base . "\")' class='left btn-floating green waves-effect waves-light white-text' title='Relatório " . $operacao[$i][1] . "'><i class='material-icons'>assignment</i></a>".
										"</div>".
									"</div>".
								"</div>".
							"</div>";
				array_push($operacaoList, $operacao[$i][0] . "|" . $operacao[$i][1] . "|" . $base);
			}
			$_SESSION['setores'] = $operacaoList;
			$htmlHeader = 	"<h3 class='green-text text-darken-3 truncate' title='Monitorar Setores'><span class='fa fa-cubes'></span> <b>Monitorar Setores</b></h3>".
							"<div class='divider'></div>";
								
			if(count($operacaodata) < 1){
				$html = "<div align='center'>".
							"<h5 class='red-text text-darken-3'><i class='fa fa-times'></i> Não há setores cadastrados!</h5>".
						"</div>";
			} else {
				$htmlHeader = $htmlHeader . 
								"<div class='col s12' align='center' style='padding:10px;'>".
									"<a href='#chartSlide_setor' style='width:100%;' onclick='callModalSlider()' class='btn btn-large grey darken-4 amber-text text-darken-1 waves-light waves-effect modal-trigger'><b><i class='fa fa-pie-chart'></i> Monitorar setores</b></a>".
								"</div>";
			}
			$html = $htmlHeader . $html;
			echo utf8_encode($html);
			
		} elseif($_POST['page'] == "canvas" && ($_POST['target'] == "setor" && (isset($_POST['setor']) && isset($_POST['database'])))){
			$html = "<div id='OPEcanvas_graph' class='col s12'>
						<div class='row' style='margin:5px;'>
							<div class='col s12'>
								<div class='col s12' style='margin-bottom:20px;'>
									<h3 class='green-text text-darken-1'><span class='fa fa-th-large'></span> Imagens " . utf8_decode($_POST['name']) . "</h3>
								</div>
								<div class='col s12'>
									<canvas id='OPEChart'>".
										"<div align='center' style='position:relative; margin-top:25%; margin-Bottom:25%;'>".
											"<div id='LoadGif'>".
											"	<img src='./img/load.png' class='image_spinner_md' style='width:100px; height:100px;' />".
											"</div>".
										"</div>".
									"</canvas>
								</div>
								<div class='col s12'>
									<div id='OPEcanvas_info'>
									</div>
								</div>
								<div class='col s12' align='center'>
									<a href='#' class='btn-flat waves-effect waves-green green-text text-darken-1' onclick='callData(\"monitorar\", \"setor\")'><i class='fa fa-arrow-left'></i> voltar</a>
								</div>
							</div>	
						</div>
					</div>";
					
			echo utf8_encode($html);
			
		} elseif($_POST['page'] == "chart" && ($_POST['target'] == 1 && (isset($_POST['setor']) && isset($_POST['database'])))){
			$setor = $_POST['setor'];
			$imagem = getAllImgBySetor($setor);
			$imagemdata = getAllImgDataBySetor($setor);
			$base = $_POST['database'];
			$computers = getAdComputers($base);
			$html = "";
			$values = array();
			$images = array();
			$imagedata = array();
			for($j = 0; $j < count($computers); $j++){
				if($computers[$j]["image"] != "" && $computers[$j]["image"] != "NOIMAGE"){
					array_push($images, $computers[$j]["image"]);
					if(isset($imagedata[$computers[$j]["image"]])){
						$imagedata[$computers[$j]["image"]]++;
					} else {
						$imagedata[$computers[$j]["image"]] = 1;
					}
				}
			}
			$outras = 0;
			$imageList = array_unique($images);
			
			foreach($imageList as $img){
				$isRegisted = 0;
				for($w = 0; $w < count($imagem); $w++){
					if($imagem[$w][2] == $img){
						$isRegisted = 1;
						$imgdataId = $imagemdata[$w][0];
						$imgsetorId = $imagemdata[$w][1];
						$imghdwId = $imagemdata[$w][2];
						$imgName = $imagem[$w][2];
						$imgDesc = $imagemdata[$w][4];
						$imgVersion = $imagemdata[$w][3];
					}
				}
				
				if($isRegisted == 1){
					$html = $img . ":" . $imagedata[$img];
				} else {
					$html = $img . "|NR:" . $imagedata[$img];
				}
				array_push($values, $html);
				$outras = $outras + $imagedata[$img];
			}
			$outras = count($computers) - $outras;			
			$outras = "Sem Imagem:" . $outras;
			array_push($values, $outras);
			echo json_encode($values, JSON_PRETTY_PRINT);
			
		} elseif($_POST['page'] == "monitorar" && $_POST['target'] == "todos-setores"){
			$operacao = getAllData("operacao");
			$operacaodata = getAllData("operacaodata");
			
			//$operacoes = $_SESSION['setores'];
			$operacaoList = array();
			$html = "";
			for($i=0; $i<count($operacao); $i++){
				/*
				$setores = explode("|", $operacoes[$i]);
				$setorId = $setores[0];
				$setorName = $setores[1];
				$setorDN = $setores[2];
				*/
				
				$setorId = $operacao[$i][0];
				$setorName = $operacao[$i][1];
				$setorDN = $operacaodata[$i][4];
				
				$html = $html.
						"<div class='carousel-item'>".
							"<div class='row'>".
								"<div class='col s12' align='center' style='margin-Bottom:50px;'>".
									//"<p>". memory_get_usage() . "</p>".
									"<h3 class='green-text text-darken-3' title='" . $setorName . "'><b><span class='fa fa-cube'></span> " . $setorName . "</b></h3>".
								"</div>".
								
								"<div class='col s12 m6'>".
									"<canvas class='canvasContent' id='Canvas_" . $setorId . "_Chart'>".
									"</canvas>".
								"</div>".
								
								"<div id='Canvas_" . $setorId . "_Info'  class='col s12 m6 lg'>".
								"</div>".
								
								"<div class='carousel-fixed-item sliderLoading' id='" . $setorId . "_Chart'>".
								"</div>".
								
							"</div>".
							
						"</div>";
			}
			$html = $html . 
					"<a href='#!' class='green-text text-darken-1' id='prevSlide' onclick='moveSlide(\"prev\")'><i class='fa fa-chevron-left fa-3x'></i></a>
					<a href='#!' class='green-text text-darken-1' id='nextSlide' onclick='moveSlide(\"next\")'><i class='fa fa-chevron-right fa-3x'></i></a>";
					
			$menubar = "<div class='col s12' id='sliderControl'>".
							"<div class='card center grey lighten-3'>".
								"<div class='card-content'>".
									"<a href='index.php' title='Parar Monitoria' class='waves-effect waves-light paddingBtn green-text text-darken-1' onclick='closeSlide()'><i class='fa fa-stop fa-2x'></i></a> ".
									"<a href='#!' title='Iniciar Monitoria' class='waves-effect waves-light paddingBtn green-text text-darken-1' onclick='playSlide()'><i class='fa fa-play fa-2x'></i></a> ".
									"<a href='#!' title='Pausar Monitoria' class='waves-effect waves-light paddingBtn green-text text-darken-1' onclick='pauseSlide()'><i class='fa fa-pause fa-2x'></i></a> ".
								"</div>".
							"</div>".
						"</div>";
			$html = $html . $menubar;
					
			echo utf8_encode($html);
		}  elseif($_POST['page'] == "chart" && ($_POST['target'] == 0 && isset($_POST['setores']))){
			
			$setorId = $_POST['setores'];
			$operacaodata = getAllOpeDNBySetor($setorId);
			$imagem = getAllImgBySetor($setorId);
			$imagemdata = getAllImgDataBySetor($setorId);
			
			//print_r($operacaodata);
			
			$base = $operacaodata[0][4];
			$computers = getAdComputers($base);
			$html = "";
			$values = array();
			$images = array();
			$imagedata = array();
			for($j = 0; $j < count($computers); $j++){
				if($computers[$j]["image"] != "" && $computers[$j]["image"] != "NOIMAGE"){
					array_push($images, $computers[$j]["image"]);
					if(isset($imagedata[$computers[$j]["image"]])){
						$imagedata[$computers[$j]["image"]]++;
					} else {
						$imagedata[$computers[$j]["image"]] = 1;
					}
				}
			}
			$outras = 0;
			$imageList = array_unique($images);
			
			foreach($imageList as $img){
				$isRegisted = 0;
				for($w = 0; $w < count($imagem); $w++){
					if($imagem[$w][2] == $img){
						$isRegisted = 1;
						$imgdataId = $imagemdata[$w][0];
						$imgsetorId = $imagemdata[$w][1];
						$imghdwId = $imagemdata[$w][2];
						$imgName = $imagem[$w][2];
						$imgDesc = $imagemdata[$w][4];
						$imgVersion = $imagemdata[$w][3];
					}
				}
				
				if($isRegisted == 1){
					$html = $img . ":" . $imagedata[$img];
				} else {
					$html = $img . "|NR:" . $imagedata[$img];
				}
				array_push($values, $html);
				$outras = $outras + $imagedata[$img];
			}
			$outras = count($computers) - $outras;			
			$outras = "Sem Imagem:" . $outras;
			array_push($values, $outras);
			
			echo json_encode($values, JSON_PRETTY_PRINT);
			
		}  elseif($_POST['page'] == "monitorar" && $_POST['target'] == "ciclo"){
			$html = "<div class='col s12 center'>".
						"<h2 class='red-text text-darken-3'><i class='fa fa-coffee'></i> Em construção!</h2>".
					"</div>";
			echo utf8_encode($html);
		}
		
	} elseif(isset($_POST['search']) && isset($_POST['target'])){
		if($_POST['search'] == "OrganizationalUnit"){
			$ous = getOU($_POST['target']);
			$objId = $_POST['objid'];
			$html = "<div class='row'>".
						"<div class='col s12'>".
							"<ul class='collection'>";
			$countItens = 0;
			if(count($ous) > 0){
				foreach($ous as $item){
					$countItens++;
					$values = explode("|", $item, 2);
					$ouname = $values[0];
					$oudn = $values[1];
					if($countItens == 1 && $_POST['target'] != "DC=call,DC=br"){
						$exprev = str_replace(",DC=call,DC=br", "", $oudn);
						$prev = explode(",", $exprev);
						$linkback = "";
						for($i=(count($prev)-1); $i >= 1; $i--){
							$goto = explode($prev[$i] . ",", $_POST['target'], 2);
							$prev[$i] = str_replace("OU=", "", $prev[$i]);
							if($i == (count($prev)-1)){
								$linkback = $linkback . "</span> <a href='#!' class='white-text' onclick='diveIn(\"" . $goto[1] . "\", \"" . $objId . "\")'><span class='fa fa-home fa-lg'></span></a>";
							} else {
								$linkback = $linkback . " <span class='white-text fa fa-angle-right'></span> <a href='#!' class='white-text' onclick='diveIn(\"" . $goto[1] . "\", \"" . $objId . "\")'>" . $prev[$i] . "</a>";
							}
						}
						$html = $html . "<li class='collection-item blue-grey'>" . $linkback . "</li>";
					}
					$html = $html . "<li id='c_" . $countItens . "' class='collection-item hoverColl' onclick='selectOU(\"" . $ouname . "\", \"" . $oudn . "\", \"" . $countItens . "\", \"" . $objId . "\")'>".
										"<div>".
											"<a href='#!' id='tc_" . $countItens . "' class='green-text' onclick='diveIn(\"" . $oudn . "\", \"" . $objId . "\")'><span class='fa fa-folder fa-lg'></span> " . $ouname . "</a>".
											"<span id='selectc_" . $countItens . "' class='white-text secondary-content' style='display:none;'>Selecionado</span>".
										"</div>".
									"</li>";
				}
			} else {
				$prev = explode(",", $_POST['target'], 2);
				$linkback = "<span class='green-text fa fa-angle-left'></span> <a href='#!' class='green-text' onclick='diveIn(\"" . $prev[1] . "\", \"" . $objId . "\")'>Voltar</a>";
				$html = $html . "<li class='collection-item'>" . $linkback . "</li>".
								"<li class='collection-item' style='padding:40px;'><span class='red-text text-darken-3 xl'><span class='fa fa-folder-open-o'></span> Unidade vazia.</span></li>";
			}
			
			$html = $html . "</ul>".
						"</div>".
					"</div>";
					
			echo utf8_encode($html);
		} elseif($_POST['search'] == "imagesBysetor"){
			$id = $_POST['setor'];
			$imgData = getAllImgBySetor($id);
			sort($imgData);
			$html = "";
			foreach($imgData as $img){
				$html = $html.
				"<option value='" . $img[0] . "|" . $img[1] . "'>" . $img[2] . "</option>";
			}
			echo $html;
		}
	} elseif(isset($_POST['action'])){
		if($_POST['action'] == "insert"){
			if($_POST['target'] == "setor"){
				$name = $_POST['name'];
				$dnName = $_POST['dnname'];
				$dn = $_POST['dn'];
				$desc = $_POST['opedesc'];
				$response = newSetor($name, $dn, $desc);
				echo $response;
			} elseif($_POST['target'] == "hardware"){
				$osname = $_POST['osname'];
				$hdwname = $_POST['hdwname'];
				$response = newHdw($hdwname, $osname);
				echo $response;
			} elseif($_POST['target'] == "imagem"){
				$imgsetorId = $_POST['setorid'];
				$imghdwId = $_POST['hdwid'];
				$imgname = $_POST['name'];
				$imgversion = $_POST['version'];
				$imgdesc = $_POST['desc'];
				$response = newImagem($imgsetorId, $imghdwId, $imgname, $imgversion, $imgdesc);
				echo $response;
			} elseif($_POST['target'] == "ciclo"){
				$name = $_POST['name'];
				$setor = $_POST['setor'];
				$imgs = $_POST['imagens'];
				$desc = $_POST['desc'];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$imagens = "";
				foreach($imgs as $img){
					$imagens = $imagens . "," . $img;
				}
				$response = newCiclo($name, $setor, $imagens, $desc, $start, $end);
				echo $response;
			}
			
		} elseif($_POST['action'] == "delete"){
			if($_POST['target'] == "setor"){
				$id = $_POST['id'];
				$response = deleteSetor($id);
				echo $response;
			} elseif($_POST['target'] == "hardware"){
				$id = $_POST['id'];
				$response = deleteHdw($id);
				echo $response;
			} elseif($_POST['target'] == "imagem"){
				$id = $_POST['id'];
				$setorid = $_POST['setorid'];
				$hdwid = $_POST['hdwid'];
				$response = deleteImagem($id, $setorid, $hdwid);
				echo $response;
			} elseif($_POST['target'] == "ciclo"){
				$id = $_POST['id'];
				$dataid = $_POST['dataid'];
				$response = deleteCiclo($id, $dataid);
				echo $response;
			}
		} elseif($_POST['action'] == 'edit'){
			if($_POST['target'] == "setor"){
				$editId = $_POST['id'];
				$editName = $_POST['name'];
				$editName = utf8_decode($editName);
				$objId = "editOPEdn";
				$editDescricao = base64_decode($_POST['descricao']);
				$editDn = base64_decode($_POST['dn']);
				$editDnTemp = str_replace("OU=", "", $editDn);
				$editDnTemp = explode(",", $editDnTemp, 2);
				$editDnName = $editDnTemp[0];
				$html = "<div class='row' id='editOPE'>".
							"<div class='col s12'>".
								"<div class='row'>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-cube fa-lg'></i> Nome do Setor:</span>".
										"<input id='editOPEname' name='editOPEname' type='text' class='validade' value='" . $editName . "'>".
										"<h5 class='green-text'>Definições do Active Directory:</h5>".
									"</div>".
									"<div class='input-field col s4 m2'>".
										"<a href='#ADdive' style='width:100%;' class='waves-effect waves-green btn green darken-3 white-text' title='Unidade Organizacional' onclick='getADstructure(\"OrganizationalUnit\", \"DC=call,DC=br\", \"" . $objId . "\")' title='Seleciona OU'><i class='fa fa-folder-o'></i></a>".
									"</div>".
									"<div class='input-field col s8 m10'>".
										"<input id='editOPEdnName' name='editOPEdnName' class='light-green-text' readonly type='text' class='validade' value='" . $editDnName . "'>".
										"<input id='editOPEdn' name='editOPEdn' class='light-green-text' readonly type='text' class='validade' value='" . $editDn . "'>".
									"</div>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-commenting-o fa-lg'></i> Descrição (<b>Opcional</b>) <span class='xs right' id='editopedesc'><b>0/255</b></span></span>".
										"<textarea maxlength='255' id='editOPEdescription' oninput='calcEditChar()' name='editOPEdescription' class='light-green-text materialize-textarea'>" . $editDescricao . "</textarea>".
									"</div>".
									"<div class='input-field col s12' align='center'>".
										"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='changeSetor(\"" . $editId . "\")' style='width:80%;'><span class='fa fa-floppy-o'></span> Salvar Alterações</span>".
										"<span class='btn-large btn-flat waves-effect waves-red red-text text-darken-3' onclick='callData(\"gerenciar\", \"operacoes\")' style='width:80%;'><span class='fa fa-times'></span> Descartar Alterações</span>".
									"</div>".
								"</div>".	
							"</div>".	
						"</div>";
						
				echo utf8_encode($html);
			} elseif($_POST['target'] == "hardware"){
				$editId = $_POST['hdwid'];
				$editName = $_POST['hdwname'];
				$editName = utf8_decode($editName);
				$editOs = $_POST['hdwos'];
				$computers = getOS();
				
				$html = "<div class='row' id='editHDW'>".
							"<div class='col s12'>".
								"<div class='row'>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-hdd-o fa-lg'></i> Modelo:</span>".
										"<input id='editHDWname' name='editHDWname' type='text' class='validade' value='" . $editName . "' maxlength='50'>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-windows fa-lg prefix green-text text-darken-3'></i>".
										"<select id='editHDWos' name='HDWos'>";
											if($computers != null){
												sort($computers);
												foreach($computers as $os){
													$isSelected = "";
													$osVal = str_replace("\0", "", $os);
													$osVal = str_replace(" ", "-", $osVal);
													$osVal = str_replace(".", "_", $osVal);
													if($osVal == $editOs){
														$isSelected = "selected";
													}
													$html = $html.
													"<option value='" . $osVal . "' " . $isSelected . ">" . $os . "</option>";
												}
											}									
										$html = $html.						
										"</select>".
									"</div>".
									"<div class='input-field col s12' align='center'>".
										"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='changeHdw(\"" . $editId . "\")' style='width:80%;'><span class='fa fa-floppy-o'></span> Salvar Alterações</span>".
										"<span class='btn-large btn-flat waves-effect waves-red red-text text-darken-3' onclick='callData(\"gerenciar\", \"hardware\")' style='width:80%;'><span class='fa fa-times'></span> Descartar Alterações</span>".
									"</div>".
								"</div>".	
							"</div>".	
						"</div>";
						
				echo utf8_encode($html);
			} elseif($_POST['target'] == "imagem"){				
				$editId = $_POST['id'];
				$editsetorId = $_POST['setorid'];
				$edithdwId = $_POST['hdwid'];
				$editName = $_POST['name'];
				$editName = utf8_decode($editName);
				$editdesc = utf8_decode($_POST['descricao']);
				$editversion = $_POST['versao'];
				$setorData = getAllData("operacao");
				$hardwareData = getAllData("maquina");
				
				$html = "<div class='row' id='editIMG'>".
							"<div class='col s12'>".
								"<div class='row'>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-th-large fa-lg'></i> Nome da Imagem:</span>".
										"<input id='editIMGname' name='editIMGname' type='text' class='validade' value='" . $editName . "'>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-cube fa-lg prefix green-text text-darken-3'></i>".
										"<select id='newIMGsetor' name='IMGsetor'>";
											sort($setorData);
											foreach($setorData as $setor){
												$selected = "";
												if($setor[0] == $editsetorId){
													$selected = "selected";
												}
												$html = $html.
												"<option value='" . $setor[0] . "' " . $selected . ">" . $setor[0] . " - ". $setor[1] . "</option>";
											}
									$html = $html.
										"</select>".
										"<label for='IMGsetor'>Setor Vinculado</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-hdd-o fa-lg prefix green-text text-darken-3'></i>".
										"<select id='newIMGhdw' name='IMGhdw'>";
											sort($hardwareData);
											foreach($hardwareData as $hdw){
												$selected = "";
												if($hdw[0] == $edithdwId){
													$selected = "selected";
												}
												$html = $html.
												"<option value='" . $hdw[0] . "' " . $selected . ">" . $hdw[1] . " [" . $hdw[2] . "]" . "</option>";
											}
									$html = $html.
										"</select>".
										"<label for='IMGhdw'>Hardware</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-book fa-lg'></i> Versão:</span>".
										"<input id='editIMGversion' name='editIMGversion' type='text' class='validade' value='" . $editversion . "'>".
									"</div>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-commenting-o fa-lg'></i> Descrição (<b>Opcional</b>) <span class='xs right' id='editimgdesc'><b>0/255</b></span></span>".
										"<textarea maxlength='255' id='editIMGdescription' oninput='calcEditIMG()' name='editIMGdescription' class='light-green-text materialize-textarea'>" . $editdesc . "</textarea>".
									"</div>".
									
									"<div class='input-field col s12' align='center'>".
										"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='changeImagem(\"" . $editId . "\", \"" . $editsetorId . "\", \"" . $edithdwId . "\")' style='width:80%;'><span class='fa fa-floppy-o'></span> Salvar Alterações</span>".
										"<span class='btn-large btn-flat waves-effect waves-red red-text text-darken-3' onclick='callData(\"gerenciar\", \"imagem\")' style='width:80%;'><span class='fa fa-times'></span> Descartar Alterações</span>".
									"</div>".
								"</div>".	
							"</div>".	
						"</div>";
						
				echo utf8_encode($html);
			} elseif($_POST['target'] == "ciclo"){
				$editId = $_POST['id'];
				$editDataId = $_POST['dataid'];
				$editName = $_POST['name'];
				$editName = utf8_decode($editName);
				$editSetor = $_POST['setor'];
				$editStart = $_POST['start'];
				$editEnd = $_POST['end'];
				$editDesc = $_POST['desc'];
				$editDesc = utf8_decode($editDesc);
				$editImagens = $_POST['imagem'];
				$expImagens = explode(',', $editImagens);
				
				$setorData = getAllData("operacao");
				$imgData = getAllData("imagem");
				$html = "<div class='row' id='editCIC'>".
							"<div class='col s12'>".
								"<div class='row'>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-table fa-lg'></i> Nome do Ciclo:</span>".
										"<input id='editCICname' name='editCICname' type='text' class='validade' value='" . $editName . "'>".
									"</div>".
									"<div class='input-field col s12'>".
										"<i class='fa fa-cube fa-lg prefix green-text text-darken-3'></i>".
										"<select id='editCICsetor' name='editCICsetor' onchange='collectCICimg(\"editCICsetor\", \"editdivCICimg\")'>";
											sort($setorData);
											foreach($setorData as $setor){
												$selected = "";
												if($setor[0] == $editSetor){
													$selected = "selected";
												}
												$html = $html.
												"<option value='" . $setor[0] . "' " . $selected . ">" . $setor[1] . "</option>";
											}
									$html = $html.
										"</select>".
										"<label for='editCICsetor'>Setor Vinculado</label>".
									"</div>".
									"<div class='input-field col s12' id='editdivCICimg'>".
										"<i class='fa fa-th-large fa-lg prefix grey-text text-darken-3'></i>".
										"<select multiple id='CICimg' name='CICimg' disabled>";
											for($j = 1; $j < count($expImagens); $j++){
												$dataCIC = explode('|', $expImagens[$j], 2);
												$result = collectImagem($dataCIC[0], $dataCIC[1]);
												$html = $html.
												"<option value='" . $dataCIC[0] . "|" . $dataCIC[1] . "' selected>" . $result . "</option>";
											}
									$html = $html.
										"</select>".
										"<label for='CICimg'>Imagens</label>".
									"</div>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-play-circle fa-lg'></i> Início:</span>".
										"<input id='editCICstart' name='editCICstart' type='text' value='" . $editStart . "' class='datepicker green-text text-darken-3'>".
									"</div>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-stop-circle fa-lg'></i> Fim:</span>".
										"<input disabled id='editCICend' name='editCICend' type='text' value='" . $editEnd . "' class='datepicker green-text text-darken-3'>".
									"</div>".
									"<div class='input-field col s12'>".
										"<span class='green-text'><i class='fa fa-commenting-o fa-lg'></i> Descrição (<b>Opcional</b>) <span class='xs right' id='editcicdesc'><b>0/255</b></span></span>".
										"<textarea maxlength='255' id='editCICdescription' oninput='calcEditCIC()' name='editCICdescription' class='light-green-text materialize-textarea'>" . $editDesc . "</textarea>".
									"</div>".
									
									"<div class='input-field col s12' align='center'>".
										"<span class='btn-large green darken-3 waves-effect waves-light white-text' onclick='changeCiclo(\"" . $editId . "\", \"" . $editDataId . "\")' style='width:80%;'><span class='fa fa-floppy-o'></span> Salvar Alterações</span>".
										"<span class='btn-large btn-flat waves-effect waves-red red-text text-darken-3' onclick='callData(\"gerenciar\", \"ciclo\")' style='width:80%;'><span class='fa fa-times'></span> Descartar Alterações</span>".
									"</div>".
								"</div>".	
							"</div>".	
						"</div>";
						
				echo utf8_encode($html);
			}
		} elseif($_POST['action'] == 'update'){
			if($_POST['target'] == "setor"){
				$id = $_POST['id'];
				$name = $_POST['name'];
				$dnName = $_POST['dnname'];
				$dn = $_POST['dn'];
				$desc = $_POST['description'];
				$response = updateSetor($id, $name, $dn, $desc);
				echo $response;
			} elseif($_POST['target'] == "hardware"){
				$id = $_POST['id'];
				$name = $_POST['name'];
				$os = $_POST['os'];
				$response = updateHdw($id, $name, $os);
				echo $response;
			} elseif($_POST['target'] == "imagem"){
				$id = $_POST['id'];
				$name = $_POST['name'];
				$setorid = $_POST['setorid'];
				$hdwid = $_POST['hdwid'];
				$newsetorid = $_POST['newsetorid'];
				$newhdwid = $_POST['newhdwid'];
				$version = $_POST['version'];
				$desc = $_POST['desc'];
				$response = updateImagem($id, $name, $setorid, $hdwid, $newsetorid, $newhdwid, $version, $desc);
				echo $response;
			} elseif($_POST['target'] == "ciclo"){
				//id: editId, dataid: editdataId, name: name, setorid: newsetorId, imgid: newImg, start: newstart, end: newend, desc: newdesc
				$id = $_POST['id'];
				$dataid = $_POST['dataid'];
				$name = $_POST['name'];
				$setorid = $_POST['setorid'];
				$imgid = $_POST['imgid'];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$desc = $_POST['desc'];
				$response = updateCiclo($id, $dataid, $name, $setorid, $imgid, $start, $end, $desc);
				echo $response;
			}
			
		}
		
	}
	
	
	
?>