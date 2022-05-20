<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Connexion</title>
	<style></style>

</head>
<body>

	<script>
		var style = document.createElement('style');
		style.type = 'text/css';
		fromstyle ='form{background: #5FBB80;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;padding: 20px;width: 600px;margin:auto;}';
		hstyle = 'h1{font-size: 60px;margin-left:160px;}';
		inputstyle = 'input{margin-left:60px;}';
		boutonstyle = '#btndiv{background-color: #77D3B0;border: solid 3px #5F5F5F;margin: 3px;margin-left:200px;padding: 10px;border-radius: 5px;display: inline-block;}';
		bodystyle = 'body{font-family: comic sans ms;background-color: #111119;border-radius: 5px;}';
			
		style.innerHTML = fromstyle + hstyle + inputstyle + bodystyle + boutonstyle;
		document.body.appendChild(style);

	</script>

	<?php
			
		//$tabl = [['admin','admin'],['toto','meh'],['caki','pomme']];


		if (!file_exists("stock.xml")) {

			echo "<script>window.alert('il n existe pas de fichier, la completion de ce formulaire creera un nouveau compte');</script>";
			// tres important
			echo "<input type='hidden' id='tabl' name='stockTab' value='1'>";
			
			$file = fopen("stock.xml", "w") or die("Unable to open file!");
			fclose($file);
			$file = fopen("stock.xml", "rb") or die("Unable to open file!");
			fclose($file);

			$tabl = [['-','-']];

		}else{


			echo "<input type='hidden' id='tabl' name='stockTab' value='1'>";
			
			$file = fopen("stock.xml", "rb") or die("Unable to open file!");
			if (filesize("stock.xml")!=0) {
				$mot = fread($file, filesize("stock.xml"));
				$lg = explode('@/l',$mot);

				for ($i=0;$i<sizeof($lg)-1;$i++) {

					$lg2 = explode("@'l",$lg[$i]);
					$tabl[$i][0] = $lg2[0];
					$tabl[$i][1] = $lg2[1];
				}
			}else{
				$tabl = [['-','-']];
			}
			fclose($file);

			//echo "$mot";	

		}

	echo '

	
	<form method="GET" action="" id="form1" name="bod">	

		<h1>Creation</h1>
		<br>
		<p STYLE="padding:0 0 0 60px;">username :<input type="text" id="username" name="username" value=" " required/> </p>
        <p STYLE="padding:0 0 0 60px;">password :<input type="text" id="password" name="password" value=" " required/> </p><br><br>
		<input type="hidden" name="creaCompte" value="1"/>

		<div id="btndiv" onclick="next()">Creation du compte</div><br><br>
		</form>
		
	';

	?>
		<script>

			var tabl = <?php echo json_encode($tabl); ?>;
			console.log(tabl);

			function next() {
            
				var user = document.getElementById('username').value;
				var pass = document.getElementById('password').value;
				if ((user != " ") && (pass != " ")) {

					//window.alert("les champs sont remplis correctement");
					var i = 0;
					
					while ((user != tabl[i][0]) && (i< tabl.length-1)) {
						i ++;
					}
					console.log(i);
					if (i < tabl.length-1) {
						
						window.alert("Cet utilisateur existe deja");
		
					}else{

						document.getElementById("form1").action = "principale.php";
						console.log(document.getElementById("form1").action);
						document.getElementById("form1").submit();

					}					

				}else{

					window.alert("les champs ne sont pas remplis correctement");

				}
				console.log(user,pass);
			}
		</script>

	</form>
	
</body>
</html>