

function loadGraph(target, obj, data, status){
	$retry = 0;
	if(status == "success"){
		if(target == 1){
			if(obj.length > 0 && data != null){
				var chart = document.getElementById('ETChart');
				var chartData = {
						labels: [],
						datasets: [
							{
								data: [],
								label: "Estações de Trabalho",
								backgroundColor: [],
								borderColor: [],
								hoverBackgroundColor: [],
								borderWidth: 2
							}]
					};
				var red;
				var green;
				var blue;
				var color = [];											
				for(var $j = 0; $j < obj.length; $j++){
					blue = Math.floor((Math.random() * 200) + 50);
					red = Math.floor((Math.random() * 200) + 50);
					green = Math.floor((Math.random() * 250) + 50);
					color[$j] = "color:rgba("+red+","+green+","+blue+",1);";
					chartData.labels[$j] = obj[$j].split(":")[0];
					chartData.datasets[0].data[$j] = obj[$j].split(":")[1];
					chartData.datasets[0].backgroundColor[$j] = "rgba("+red+","+green+","+blue+",0.7)";
					chartData.datasets[0].borderColor[$j] = "rgba("+red+","+green+","+blue+",1)";
					chartData.datasets[0].hoverBackgroundColor[$j] = "rgba("+red+","+green+","+blue+",1)";
				};
					
				var myChart = new Chart(chart, {
					type: 'pie',
					data: chartData,
					options: {
						animation: {
							duration: 1000
						},
						legend:{
							display: false
						}
					}
				});
				
				var bg;
				var total = 0;
				var datainsert = "<div class='row'><div class='col-xs-12 blue'>Sistemas Operacionais <span class='blue' style='position:absolute; right:5px;'>Qtd.</span></div>";
				for(var $i = 0; $i < chartData.labels.length; $i++){
					bg = "transparent";
					if($i%2 == 0){
						bg = "rgba(200,200,240,0.5)";
					}
					datainsert+= "<div class='col-xs-12' style='background-color:" + bg + "'><span class='fa fa-square' style='" + color[$i] + "'></span> " + chartData.labels[$i] + ": <span class='blue' style='position:absolute; right:5px;'>" + chartData.datasets[0].data[$i] + "</span></div>";
					total += parseInt(chartData.datasets[0].data[$i]);
				}
				datainsert+= "<hr /><div class='col-xs-12 red'>TOTAL: <span class='red' style='position:absolute; right:5px;'>" + total + "</span></div>";
				datainsert+= "</div>";
				document.getElementById("ETcanvas_info").innerHTML = datainsert;
			}
		} else if (target == 2){
			if(obj.length > 0 && data != null){
				var chart = document.getElementById('SVChart');
				var chartData = {
						labels: [],
						datasets: [
							{
								data: [],
								label: "Servidores",
								backgroundColor: [],
								borderColor: [],
								hoverBackgroundColor: [],
								borderWidth: 2
							}]
					};
				var red;
				var green;
				var blue;
				var color = [];
				for(var $j = 0; $j < obj.length; $j++){
					red = Math.floor((Math.random() * 200) + 50);
					green = Math.floor((Math.random() * 200) + 50);						
					blue = Math.floor((Math.random() * 200) + 50);
					color[$j] = "color:rgba("+red+","+green+","+blue+",1);";
					chartData.labels[$j] = obj[$j].split(":")[0];
					chartData.datasets[0].data[$j] = obj[$j].split(":")[1];
					chartData.datasets[0].backgroundColor[$j] = "rgba("+red+","+green+","+blue+",0.7)";
					chartData.datasets[0].borderColor[$j] = "rgba("+red+","+green+","+blue+",1)";
					chartData.datasets[0].hoverBackgroundColor[$j] = "rgba("+red+","+green+","+blue+",1)";
				};
					
				var myChart = new Chart(chart, {
					type: 'pie',
					data: chartData,
					options: {
						animation: {
							duration: 1000
						},
						legend:{
							display: false
						}
					}
				});
				
				var bg;
				var total = 0;
				var datainsert = "<div class='row'><div class='col-xs-12 blue'>Siatemas Operacionais <span class='blue' style='position:absolute; right:5px;'>Qtd.</span></div>";
				for(var $i = 0; $i < chartData.labels.length; $i++){
					bg = "transparent";
					if($i%2 == 0){
						bg = "rgba(200,200,240,0.5)";
					}
					datainsert+= "<div class='col-xs-12' style='background-color:" + bg + "'><span class='fa fa-square' style='" + color[$i] + "'></span> " + chartData.labels[$i] + ": <span class='blue' style='position:absolute; right:5px;'>" + chartData.datasets[0].data[$i] + "</span></div>";
					total += parseInt(chartData.datasets[0].data[$i]);
				}
				datainsert+= "<hr /><div class='col-xs-12 red'>TOTAL: <span class='red' style='position:absolute; right:5px;'>" + total + "</span></div>";
				datainsert+= "</div>";
				document.getElementById("SVcanvas_info").innerHTML = datainsert;
			}
			
		} else if (target == 3){
			if(obj.length > 0 && data != null){
				var chart = document.getElementById('QTChart');
				var chartData = {
						labels: [],
						datasets: [
							{
								data: [],
								label: "Máquinas Adicionadas",
								backgroundColor: [],
								borderColor: [],
								hoverBackgroundColor: [],
								borderWidth: 2
							}]
					};
					
					for(var $j = 0; $j < obj.length; $j++){
						chartData.labels[$j] = obj[$j].split(":")[0];
						chartData.datasets[0].data[$j] = obj[$j].split(":")[1];
						chartData.datasets[0].backgroundColor[$j] = "rgba(0,120,200,0.7)";
						chartData.datasets[0].borderColor[$j] = "rgba(0,120,200,1)";
						chartData.datasets[0].hoverBackgroundColor[$j] = "rgba(0,120,200,1)";
					}
				var myChart = new Chart(chart, {
					type: 'bar',
					data: chartData,
					options: {
						animation: {
							duration: 1000
						},
						legend:{
							display: false
						}
					}
				});
				
				var bg;
				var datainsert = "<hr /><div class='row'><div class='col-xs-12 blue'>Data <span style='position:absolute; right:5px;'>Qtd.</span></div>";
				for(var $i = 0; $i < chartData.labels.length; $i++){
					bg = "transparent";
					if($i%2 == 0){
						bg = "rgba(200,200,240,0.5)"
					}
					datainsert+= "<div class='col-xs-12' style='background-color:" + bg + "'>" + chartData.labels[$i] + ": <span style='position:absolute; right:5px;' align='center' class='blue'>" + chartData.datasets[0].data[$i] + "</span></div>";
				}
				datainsert+= "</div>";
				document.getElementById("QTcanvas_info").innerHTML = datainsert;
			}
		} else if (target == 4){
			if(obj.length > 0 && data != null){
				var chart = document.getElementById('OffChart');
				var chartData = {
						labels: [],
						datasets: [
							{
								data: [],
								label: "Quantitativo",
								backgroundColor: [],
								borderColor: [],
								hoverBackgroundColor: [],
								borderWidth: 2
							}]
					};
					var red;
					var green;
					var blue;
					var color = [];
					for(var $j = 0; $j < obj.length; $j++){
						red = Math.floor((Math.random() * 200) + 50);
						green = Math.floor((Math.random() * 200) + 50);						
						blue = Math.floor((Math.random() * 200) + 50);
						color[$j] = "color:rgba("+red+","+green+","+blue+",1);";
						chartData.labels[$j] = obj[$j].split(":")[0];
						chartData.datasets[0].data[$j] = obj[$j].split(":")[1];
						chartData.datasets[0].backgroundColor[$j] = "rgba("+red+","+green+","+blue+",0.7)";
						chartData.datasets[0].borderColor[$j] = "rgba("+red+","+green+","+blue+",1)";
						chartData.datasets[0].hoverBackgroundColor[$j] = "rgba("+red+","+green+","+blue+",1)";
					}
				var myChart = new Chart(chart, {
					type: 'doughnut',
					data: chartData,
					options: {
						animation: {
						duration: 1000
						},
						legend:{
							display: false
						}
					}
				});
				var bg;
				var total = 0;
				var inativas = 0;
				var datainsert = "<hr /><div class='row'><div class='col-xs-12 blue'>Data <span class='blue' style='position:absolute; right:5px;'>Qtd.</span></div>";
				for(var $i = 0; $i < chartData.labels.length; $i++){
					bg = "transparent";
					if($i%2 == 0){
						bg = "rgba(200,200,240,0.5)"
					}
					total += parseInt(chartData.datasets[0].data[$i]);
					if($i != (chartData.labels.length - 1)){
						datainsert+= "<div class='col-xs-12' style='background-color:" + bg + "'><span class='fa fa-square' style='" + color[$i] + "'></span> " + chartData.labels[$i] + ": <span class='blue' style='position:absolute; right:5px;'><a href='#!' class='blue' data-toggle='modal' data-target='#report_modal' onclick='callList(\"" + chartData.labels[$i].split(" ")[0] + "\")'>" + chartData.datasets[0].data[$i] + " <span class='fa fa-file'></span></a></span></div>";
						inativas += parseInt(chartData.datasets[0].data[$i]);
					} else {
						datainsert+= "<div class='col-xs-12' style='background-color:transparent;'><span class='fa fa-power-off green'></span> " + chartData.labels[$i] + ": <span class='black' style='position:absolute; right:5px;'>" + chartData.datasets[0].data[$i] + "</span></div>";
					}
				}
				datainsert+= "<div class='col-xs-12'><span class='fa fa-power-off red'></span> Inativas: <span class='black' style='position:absolute; right:5px;'>" + inativas + "</span></div>";
				datainsert+= "<div class='col-xs-12 red'>TOTAL: <span class='red' style='position:absolute; right:5px;'>" + total + "</span></div>";
				datainsert+= "</div>";
				document.getElementById("Offcanvas_info").innerHTML = datainsert;
			}
		}
	} else {
		console.log("ERROR");
	}
}