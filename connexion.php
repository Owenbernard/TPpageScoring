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
		boutonstyle = '#btndiv{background-color: #77D3B0;border: solid 3px #5F5F5F;margin: 3px;margin-left:240px;padding: 10px;border-radius: 5px;display: inline-block;}';
		bodystyle = 'body{font-family: comic sans ms;background-color: #111119;border-radius: 5px;}';
			
		style.innerHTML = fromstyle + hstyle + inputstyle + bodystyle + boutonstyle;
		document.body.appendChild(style);

	</script>

	<?php
			
		//$tabl = [['admin','admin'],['toto','meh'],['caki','pomme']];


		if (file_exists("stock.xml")) {

			//header('location:index.php');
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
				header('location:CreationCompte.php');
			}
			fclose($file);

			//echo "$mot";
			
		   //le fichier xml est au même niveau que le fichier PHP qui le manipule
		   //$fichier = 'stock.xml';
		   //$contenu = simplexml_load_file($fichier);
		    //echo '<pre>';
			//print_r($contenu);
			//echo '</pre>';

		}else{
			
			echo "<script>window.alert('il n'existe pas de fichier, la completion de ce formulaire creera un nouveau compte');</script>";
			// tres important
			header('location:CreationCompte.php');
				
		}

	echo '

	
	<form method="GET" action="" id="form1" name="bod">	

		<h1>connexion</h1>
		<br>
		<p STYLE="padding:0 0 0 60px;">username :<input type="text" id="username" name="username" value=" " required/> </p>
        <p STYLE="padding:0 0 0 60px;">password :<input type="text" id="password" name="password" value=" " required/> </p><br><br>
		

		<div id="btndiv" onclick="next()">Valider</div><br><br>
		<p style="padding:0 0 0 80px;">Pas de compte ? : <a href="CreationCompte.php">creer un compte</a><br></p>

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
					if (i < tabl.length) {
						
						if (tabl[i][1] == pass) {
							//window.alert("Bienvenue");

							document.getElementById("form1").action = "principale.php";
							console.log(document.getElementById("form1").action);
							document.getElementById("form1").submit();


						}else{
							window.alert("le mot de passe ne correspond pas au nom donne");
						}
					}else{

						window.alert("le nom n'existe pas, vous pouvez creer un nouveau compte avec");
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