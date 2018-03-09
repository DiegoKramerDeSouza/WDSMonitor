<?php 
	require_once("structure.php");
	//Escreve cabeçalho
	echo $headerHtml;
	/*
	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if($actual_link == "catalogo.call.br/catalog/login.php"){
		header("Location:access.php?user=s00161");
	}
	*/
?>
<body>
	<main>
		<div id="loading">
			<div id="dialogLoading" align="center">
				<div>
					Aguarde...</span><br/>
				</div>
				<div id="loadGif">
					<img src="./img/load.png" class="image_spinner_md" ></span>
				</div>
			</div>
		</div>
		
		<div id="imgBG">
			<img src="img/layer2.png" id="bgLayer" />
			<!--<img src="img/bg6.jpg" id="bg" />-->
		</div>
		<div class="row">
			<div class="centro col s12 m8 l6 offset-m2 offset-l3" id="loginPanel">
				<div class="card blue-grey darken-4">
					<form method="post" name="login" id="login" action="access.php">
						<div class="card-content lighten-2">
							<div class="row">
								<div class="col s12 truncate title">
									<b><span class="light-green-text text-accent-4">WDS Monitor</span></b> 
									<li class='divider light-green'></li>
								</div>
							</div>
							<div class="row">
								<div class="col s6" >
									<span class="card-title light-green-text text-accent-4" style="font-size:36px;">Login</span>
								</div>
								<div class="col s6" style="border-left: 1px solid rgba(80,80,80,0.2);">
									<div class="input-field" style="max-height:45px;">
										<input type="text" autocomplete="off" class="validade input-block-level green-text" name="user" id="user" required autofocus />
										<label class="active" for="user"><span class="fa fa-user fa-lg"></span> Usuário</label>
									</div>
									<div class="input-field" style="max-height:45px;">
										<input type="password" autocomplete="off" class="validade input-block-level green-text" name="password" id="password" required />
										<label class="active" for="password"><span class="fa fa-lock fa-lg"></span> senha</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-action blue-grey darken-2" align="right" style="max-height:60px;">
							<b><input type="submit" class="green-text waves-effect waves-green btn-flat" style="opacity:1.0; position:relative; right:-20px;" id="Acessar" value="Acessar" /></b>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>
	<?php
		echo $scriptsHtml;
	?>

</body>
</html>