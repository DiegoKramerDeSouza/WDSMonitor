<?php
//Index.php construído automaticamente pelo Constructor.php
//Iniciado em: 18 de Dezembro de 2017 às 14:28
	if(session_id() == '') {
		session_start();
	}
	if(isset($_SESSION['active']) && isset($_SESSION['wdsmonitor'])){
		if($_SESSION['active'] == 1 && $_SESSION['wdsmonitor'] == true){
			require_once("structure.php");
			require_once("functions.php");
	
			$currentUser = $_SESSION['name'];
			$login = base64_encode($_SESSION['matricula']);
			$senha = base64_encode($_SESSION['senha']);
			$photo = $_SESSION['photo'];
			
			//Escreve cabeçalho HTML
			echo $headerHtml;

		} else {
			header("Location:logout.php");
		}
	} else {
		header("Location:login.php");
	}
 
?>
<body class="grey lighten-2" onclick='closeBtnFAB()'>
	<main>
		<header id='index-top'>
			<nav class="nav-extended grey darken-4">
				<div class="nav-wrapper">
					<a href='#!' class='button-collapse light-green-text text-accent-4 right' data-activates='slide_bar' title='Menu'><i class='fa fa-bars fa-2x'></i></a>
					<a href='index.php' class='brand-logo'><span class='green-text text-darken-2 truncate navtitle'><b>WDS Monitor</b></span></a>
					<ul id='nav-mobile' class='right hide-on-med-and-down'>
						<li>
							<a id='homeicon' href='index.php'>
								<span class='green-text text-darken-1'><span class='fa fa-home fa-lg'></span> <b>Início</b></span>
							</a>
						</li>
						<li>
							<a class='dropdown-button' id='monDrop' href='#!' data-activates='dropMon'>
								<b><span class='green-text text-darken-1'><span class='fa fa-pie-chart fa-lg'></span> Monitorar</span></b>
							</a>
						</li>
						<li>
							<a class='dropdown-button' id='gerDrop' href='#!' data-activates='dropGer'>
								<b><span class='green-text text-darken-1'><span class='fa fa-sitemap fa-lg'></span> Gerenciar</span></b>
							</a>
						</li>						
						<li>
							<a class='dropdown-button' id='userDropDown' href='#!' data-activates='myProfile'>
								<div id='userChip' class='chip green darken-1 white-text'>
								<?php
									echo $photo . utf8_encode($currentUser);
								?>
								</div>
							</a>
						</li>
					</ul>
				</div>		
				<ul id='myProfile' class='dropdown-content' style='margin-top:60px;'>
					<li class='grey darken-4'><a href='#!' onclick='logoff()' class='red-text text-darken-1'><i class='fa fa-sign-out fa-lg'></i> Sair</a></li>
				</ul>
				<ul id='dropGer' class='dropdown-content' style='margin-top:60px;'>
					<li class='grey darken-4'><a href='#' class='green-text text-darken-1' onclick='callData("gerenciar", "operacoes")'><i class='fa fa-cube'></i>Setores</a></li>
					<li class='grey darken-4'><a href='#' class='green-text text-darken-1' onclick='callData("gerenciar", "hardware")'><i class='fa fa-hdd-o'></i>Hardware</a></li>
					<li class='grey darken-4'><a href='#' class='green-text text-darken-1' onclick='callData("gerenciar", "imagem")'><i class='fa fa-th-large'></i>Imagens</a></li>
					<li class='grey darken-4'><a href='#' class='green-text text-darken-1' onclick='callData("gerenciar", "ciclo")'><i class='fa fa-table'></i>Ciclos</a></li>
				</ul>
				<ul id='dropMon' class='dropdown-content' style='margin-top:60px;'>
					<li class='grey darken-4'><a href='#' class='green-text text-darken-1' onclick='callData("monitorar", "setor")'><i class='fa fa-cubes'></i>Setores</a></li>
					<li class='grey darken-4'><a href='#' class='green-text text-darken-1' onclick='callData("monitorar", "ciclo")'><i class='fa fa-calendar'></i>Ciclos</a></li>
				</ul>
			</nav>
		</header>
		
		<div id="loading">
			<div id="dialogLoading" align="center">
				<div>
					Aguarde...<br/>
				</div>
				<div id="loadGif">
					<img src="./img/load.png" class="image_spinner_md" ></span>
				</div>
			</div>
		</div>
		
		<ul id='slide_bar' class='side-nav grey darken-4'>
			<li>
				<div class='user-view'>
					<div class='background'>
						<img src='img/layer2.png' style='width:100%; height: 150px;'>
					</div>
					<?php
						$countAll = getcount();					
						$countOPE = $countAll["OPE"];
						$countMAQ = $countAll["MAQ"];
						$countIMG = $countAll["IMG"];
						$countCIC = $countAll["CIC"];
					?>
					<div id='userChip' class='chip green darken-2 white-text' style='position:relative; top:-45px; margin-left:5px;'>
					<?php
						echo $photo . utf8_encode($currentUser);
					?>
					</div>
				</div>
			</li>
			<li class='green-text text-darken-2' style='position:relative; top:-45px;'>
				<ul class='collapsible' data-collapsible='accordion'>
					<li>
						<div class='collapsible-header' onclick='gohome()'>
							<span class='green-text text-darken-2 md'><span class='fa fa-home'></span> <b>Início</b></span>
						</div>
					</li>
					<li>
						<div class='collapsible-header'>
							<span class='md'><span class='fa fa-pie-chart'></span> <b>Monitorar</b></span>
						</div>
						<div class='collapsible-body green darken-1' style='padding:0px;'>
							<a href='#!' class=' white-text' onclick='callData("monitorar", "setor")'><span class='fa fa-cubes'></span>Setores</a>
							<a href='#!' class=' white-text' onclick='callData("monitorar", "ciclo")'><span class='fa fa-calendar'></span>Ciclos</a>
						</div>
					</li>
					<li>
						<div class='collapsible-header'>
							<span class='md'><span class='fa fa-sitemap'></span> <b>Gerenciar</b></span>
						</div>
						<div class='collapsible-body green darken-1' style='padding:0px;'>
							<a href='#!' class=' white-text' onclick='callData("gerenciar", "operacoes")'><span class='fa fa-cube'></span>Setores</a>
							<a href='#!' class=' white-text' onclick='callData("gerenciar", "hardware")'><span class='fa fa-hdd-o'></span>Hardware</a>
							<a href='#!' class=' white-text' onclick='callData("gerenciar", "imagem")'><span class='fa fa-th-large'></span>Imagens</a>
							<a href='#!' class=' white-text' onclick='callData("gerenciar", "ciclo")'><span class='fa fa-table'></span>Ciclos</a>
						</div>
					</li>
					<li>
						<div class='collapsible-header' onclick='logoff()'>
							<span class='green-text text-darken-2 md'><span class='fa fa-sign-out'></span> <b>Sair</b></span>
						</div>
					</li>
				</ul>
			</li>
		</ul>

		<div class="row container">
			<div class="col s12 card" id='information' style='padding-bottom:10px; padding-top:10px;'>
				<!--***************-->
				<!--JSON Data here!-->
				<!--***************-->
				<div id='presentation'>
					<div class="section">
						<div class="row">
							<div class="col s12 m6 innerBox">
								<div class="icon-block" onclick='callData("gerenciar", "operacoes")'>
									<h1 class="center green-text text-darken-3"><span class='fa fa-cube'></span><span id='countOPE'><?php echo $countOPE; ?></span></h1>
									<h5 class="center">Setores</h5>
									<p class="light justified">Setores registrados no sistema. Faça o registro dos setores acessando o campo <span class='green-text text-darken-1'><b>Gerenciar</b></span> e selecionando "Adicionar" na opção <span class='green-text text-darken-1'><b>Setor</b></span>.</p>
								</div>
							</div>
							<div class="col s12 m6 innerBox">
								<div class="icon-block" onclick='callData("gerenciar", "hardware")'>
									<h1 class="center green-text text-darken-3"><span class='fa fa-hdd-o'></span><span id='countHDW'><?php echo $countMAQ; ?></span></h1>
									<h5 class="center">Hardware</h5>
									<p class="light justified">Hardwares registrados no sistema. Faça o registro de Hardware de cada setor acessando o campo <span class='green-text text-darken-1'><b>Gerenciar</b></span> e selecionando "Adicionar" na opção <span class='green-text text-darken-1'><b>Hardware</b></span>.</p>
								</div>
							</div>
							<div class="col s12 m6 innerBox">
								<div class="icon-block" onclick='callData("gerenciar", "imagem")'>
									<h1 class="center green-text text-darken-3"><span class='fa fa-th-large'></span><span id='countIMG'><?php echo $countIMG; ?></span></h1>
									<h5 class="center">Imagens</h5>
									<p class="light justified">Imagens registradas no sistema. Faça o registro das Imagens criadas acessando o campo <span class='green-text text-darken-1'><b>Gerenciar</b></span> e selecionando "Adicionar" na opção <span class='green-text text-darken-1'><b>Imagens</b></span>.</p>
								</div>
							</div>
							<div class="col s12 m6 innerBox">
								<div class="icon-block" onclick='callData("gerenciar", "ciclo")'>
									<h1 class="center green-text text-darken-3"><span class='fa fa-table'></span><span id='countCIC'><?php echo $countCIC; ?></span></h1>
									<h5 class="center">Ciclos</h5>
									<p class="light justified">Ciclos de Imagens registrados no sistema. Faça o registro dos Ciclos criados acessando o campo <span class='green-text text-darken-1'><b>Gerenciar</b></span> e selecionando "Adicionar" na opção <span class='green-text text-darken-1'><b>Ciclos</b></span>.</p>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<!--Modals.START-->
		<div id='ADdive' class='modal modal-fixed-footer light-green-text'>
			<div class='modal-content green-text'>
				<h4><span class='fa fa-cubes'></span> Active Directory Dive</h4>
				<div id='entryDetail'>
					<!--*******************-->
					<!--Ajax Detail Content-->
					<!--*******************-->
				</div>
			</div>
			<div class='modal-footer'>
				<a href='#!' class='modal-action modal-close waves-effect waves-green btn-flat green-text text-darken-3'><i class='fa fa-check'></i> Confirmar</a>
				<a href='#!' onclick='cancelModalADdive()' class='modal-action modal-close waves-effect waves-red btn-flat red-text text-darken-4'><i class='fa fa-times'></i> Cancelar</a>
			</div>
		</div>
		
		<div id='contactModal' class='modal modal-fixed-footer' style='width:90%; height:90%;'>
			<div id='contact-content' class='modal-content'>
			</div>
			<div class='modal-footer'>
				<a href='#!' class='modal-action modal-close waves-effect waves-green btn-flat green-text text-darken-3'><i class='fa fa-check'></i> Confirmar</a>
				<a href='#!' onclick='cancelModalADdive()' class='modal-action modal-close waves-effect waves-red btn-flat red-text text-darken-3'><i class='fa fa-times'></i> Cancelar</a>
			</div>
		</div>
		
		<div id='chartSlide_setor' class='modal bottom-sheet grey lighten-3'>
			<div class='modal-content' >
				<a href='index.php' class='right grey-text text-darken-1' style='position:absolute; right:2%; z-index:999;' onclick='closeSlide()'><i class='fa fa-times fa-2x'></i></a>
				<div id='slideBody' class='carousel carousel-slider' style='position:fixed;	top: 55%; left:50%; transform: translate(-50%, -50%); width: 100%; min-height: 100%;'>
					<!--*******************-->
					<!--Ajax Detail Content-->
					<!--*******************-->
				</div>
			</div>
		</div>
		
		<div id='chartSlide_ciclo' class='modal bottom-sheet'>
			<div class='modal-content'>
				<a href='#!' class='right modal-action modal-close grey-text text-darken-1'><i class='fa fa-times fa-2x'></i></a>
				<h4 class='green-text text-darken-1'><span class='fa fa-cubes'></span> Monitoria de setores</h4>
				<div id='slideBody'>
					<!--*******************-->
					<!--Ajax Detail Content-->
					<!--*******************-->
				</div>
			</div>
		</div>
		
		<!--Modals.END-->
		
		<!--Float Button.START-->
		<div class='fixed-action-btn vertical click-to-toggle hide-on-med-and-down'>
			<a class='btn-floating btn-large green darken-1 waves-effect waves-light'>
				<i class='material-icons large'>apps</i>
			</a>
			<ul>
				<li><a href='index.php' class='tooltipped btn-floating green darken-2 white-text' data-position='left' data-delay='50' data-tooltip='Início'><i class='fa fa-home'></i></a></li>
				<!--<li><a href='#!' class='tooltipped btn-floating green darken-2 white-text' data-position='left' data-delay='50' data-tooltip='Gerenciar Setores' onclick='callData("gerenciar", "operacoes")'><i class='fa fa-cube'></i></a></li>
				<li><a href='#!' class='tooltipped btn-floating green darken-2 white-text' data-position='left' data-delay='50' data-tooltip='Gerenciar Hardware' onclick='callData("gerenciar", "hardware")'><i class='fa fa-hdd-o'></i></a></li>
				<li><a href='#!' class='tooltipped btn-floating green darken-2 white-text' data-position='left' data-delay='50' data-tooltip='Gerenciar Imagens' onclick='callData("gerenciar", "imagem")'><i class='fa fa-th-large'></i></a></li>
				<li><a href='#!' class='tooltipped btn-floating green darken-2 white-text' data-position='left' data-delay='50' data-tooltip='Gerenciar Ciclos' onclick='callData("gerenciar", "ciclo")'><i class='fa fa-table'></i></a></li>
				-->
				<li><a href='#chartSlide_setor' class='tooltipped btn-floating green darken-2 white-text modal-trigger' data-position='left' data-delay='50' data-tooltip='Monitorar Setores' onclick='callModalSlider()'><i class='fa fa-cubes'></i></a></li>
				<li><a href='#!' class='tooltipped btn-floating green darken-2 white-text' data-position='left' data-delay='50' data-tooltip='Monitorar Ciclos' onclick='callData("monitorar", "ciclo")'><i class='fa fa-calendar'></i></a></li>
			</ul>
		</div>
		<!--Float Button.END-->
		
		<!--Monitor Control.START-->
			<input type='hidden' id='setorImgId' /input>
			<input type='hidden' id='setorImgName' /input>
			<input type='hidden' id='setorImgBase' /input>
		<!--Monitor Control.END-->
	</main>
	
	<footer class="page-footer grey darken-4">
		<div class="grey darken-4">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text">Controle seus serviços e ambientes do WDS.</h5>
					<p class="grey-text text-lighten-4">Cadastre e monitore ciclos de distribuição de imagens do Windows Deployment Services em toda a sua organização.
														Construa a disposição de hardware em cada setor, atribuindo a cada ciclo as imagens que serão utilizadas.</p>
				</div>				
			</div>
		</div>
		<div class="footer-copyright">
			<div style='margin-left:10px;'>
				2018 <span class="white-text"><b>Equipe de <span class='green-text text-darken-1'>Colaboração de Serviços</span></b></span>
			</div>
		</div>
	</footer>
		
	
	<?php
		echo $scriptsHtml;
	?>
</body>

</html>