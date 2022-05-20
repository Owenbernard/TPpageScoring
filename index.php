<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Index</title>
	<style></style>

</head>
<body>

	<script>
		var style = document.createElement('style');
		style.type = 'text/css';
		fromstyle ='form{background: #5FBB80;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;padding: 20px;width: 600px;margin:auto;}';
		hstyle = 'h1{font-size: 80px;margin-left:160px;}';
		h2style = 'h2{font-size: 30px;text-align:center	;}';
		boutonstyle = 'div{background-color: #77D3B0;border: solid 3px #5F5F5F;margin: 3px;margin-left:240px;padding: 10px;border-radius: 5px;display: inline-block;}';
		bodystyle = 'body{font-family: comic sans ms;background-color: #111119;border-radius: 5px;}';
			
		style.innerHTML = fromstyle + hstyle + h2style + bodystyle + boutonstyle;
		document.body.appendChild(style);

	</script>

	<form method="GET" action="" id="form1" name="bod">	

		<h1>Scoring</h1>
		<h2>Regarder les meilleurs scores de chaques joueurs</h2>
		<br>
		<div id="btndiv">Se connecter</div>
		<br>
		<script>
			window.onload = function () {
			var el = document.getElementById("btndiv");
			el.onclick = sayHello;
			}

			function sayHello() {
				window.location.href = "connexion.php";
			}
		</script>

	</form>
	
</body>
<footer>
	<form method="GET" action="" id="form2" name="foot">	
	<?php 

		include 'footer.php';

	?>
	</form>
</footer>
</html>
