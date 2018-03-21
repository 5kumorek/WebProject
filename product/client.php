<?php session_start();
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Zad_1</title>
		<link rel="StyleSheet" href="style.css" type="text/css">
		<link href="css/bootstrap.min.css" rel="StyleSheet">
		<script src="jquery-3.2.1.min.js"></script>
		 <script type="text/javascript" src="ajax.js"></script>
		<script type="text/javascript" src="localDB.js"></script>
		<script src="js/bootstrap.min.js"></script> 
	</head>
	<body>
		<script src="js/bootstrap.min.js"></script> 
	<article>
		<div class="page-header" style="text-align:center;"><h1>Jakas tam cos</h1></div>
		<div class="modal-body-row" >
			<span id="message" style="font-size: 20px;"></span>
        	<div class="col-md-4">
				<div>
					<h3>Dane z Servera</h3>
					<input type="submit" value='Tabela' id="getTable"/>
					<input type="submit" value='Wykres' id='pie'/>
					<button onclick="document.getElementById('my_table').innerHTML='';">Clear</button>
					<div id="my_table" style="height: 300px; width: 100%;"></div>
					<div id="chartContainer" style="height: 300px; width: 100%;"></div>
					<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				</div>
			</div>
			<div class="col-md-4">
				<div>
					<h3>Dane lokalne</h3>
					<button id='read'>Tabela </button>
					<button onclick="removeAll();removeAll()">Remove</button>
					<button onclick="document.getElementById('container').innerHTML='';">Clear</button>
					<input type="submit" value='Push data' id="push"/>
					<div id="container"></div>	
				</div>
			</div>
			<div class="col-md-4">
				<div>
					<h3>Dodawanie recordów</h3>
					<div class="col-sm-4">
						<span>Nazwa sprzetu</span>
						<input type="text" name="name" id="name"/>
					</div>
					<div class="col-sm-4">
						<span>Ilosc</span>
						<input type="text" name="quantity" id="quantity"/>
					</div>
					<div class="col-sm-4">
						<span>cos</span></br>
						<input type="submit" value="INSERT" id="insert"/>
					</div>
				</div>
				<br><br><br>
				
			</div>
					
		</div>
	</article>
	</body>
</html>
