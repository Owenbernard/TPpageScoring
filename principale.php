<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Scoring</title>
	<style>
	
	h1 {
		width:500px;
		margin: 0 auto;
		text-align: center;
	
	}
	body{
		font-family: comic sans ms;
		background-color: #111119;
		border-radius: 5px;
	}
	form{
		padding: 20px;
		width: 1000px;
		margin:auto;
	}
	#form2 {
		background: #5FBB80;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
	}
	#InputValue {
		background: #5FBB80;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
	}
	#form3 {
		background: #5fbb99;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
	}
	div{
		background-color: #77D3B0;
		border: solid 3px #5F5F5F;
		margin: 3px;
		padding: 20px;
		border-radius: 5px;
		display: inline-block;
	}
	#AffichageScore {
		width: 200px;
	}
	</style>

</head>
<body>

    <?php

        if (isset($_REQUEST["creaCompte"])) {
 
            $user = $_REQUEST["username"];
            $pass = $_REQUEST["password"];


			if (file_exists("stock.xml")) {
			// si le fichier existe
				//recup du fichier
				$file = fopen("stock.xml", "rb") or die("Unable to open file!");
				//si il n'est pas vide'
				if (filesize("stock.xml")!=0) {
					//on recup ce qui il y a dedans
					$mot = fread($file, filesize("stock.xml"));
					fclose($file);

					//separation par utilisateur
					$lg = explode('@/l',$mot);

					//mise en place nom user et mdp
					for ($i=0;$i<sizeof($lg)-1;$i++) {

						$lg2 = explode("@'l",$lg[$i]);
						$tablSave[$i][0] = $lg2[0];
						$tablSave[$i][1] = $lg2[1];
					}

					//insertion de balise pour preparer le fichier
					$i = 0;
					$xml = "";
					for ($i=0;$i<(sizeof($tablSave));$i++) {
						$xml = $xml.$tablSave[$i][0]."@'l".$tablSave[$i][1]."@/l";
						echo"<br>";
						//print_r($xml);
					}
					//ajout du nouveau utilisateur
					$xml = $xml.$user."@'l".$pass."@/l";
					$file = fopen("stock.xml", "w") or die("Unable to open file!");
					//mise dans le fichier
					fwrite($file, $xml);
					fclose($file);
				}else{
				//si vide 
					//ecriture du nouveau utilisateur
					$xml = $user."@'l".$pass."@/l";
					$file = fopen("stock.xml", "w") or die("Unable to open file!");
					//mise dans le fichier
					fwrite($file, $xml);
					fclose($file);
				}
			}else{
			//si le fichier n'existe pas
				$xml = $user."@'l".$pass."@/l";
				$file = fopen("stock.xml", "w") or die("Unable to open file!");
				//mise dans le fichier
				fwrite($file, $xml);
				fclose($file);

			}

        }
        $user = $_REQUEST["username"];
       
	?>


	<form method="GET" action="" id="form2" name="formulaire">	
		<input type="hidden" id="tab" name="tableau" value="" > </input><br><br>
		<p><a href="index.php">Deconnexion</a></p>
		<h1>Bienvenue : <?php echo $user ?></h1>
		<input type="hidden" id="nam" name="username" value="" > </input><br><br>
		
		<?php


			if (isset($_REQUEST["tableau"])) {	
						

				$data = $_REQUEST["tableau"];
				$data = explode(",", $data);
				$i =0;
				$y =0;

				for ($y=0;$y<sizeof($data)/4;$y++) {
					for ($i=0;$i<4;$i++) {
						$tabScore[$y][$i] = $data[($y*4)+$i];
					}
				}

				
				$myJSON = json_encode($tabScore);

				//echo $myJSON;
				$file = fopen("stock.json", "w") or die("Unable to open file!");
				fwrite($file, $myJSON);
				fclose($file);			
							
			}else{
			

				if (file_exists("stock.json")) {
					
					$file = fopen("stock.json", "rb") or die("Unable to open file!");
					$tab = fread($file, filesize("stock.json"));
					fclose($file);

					$tab = str_replace('"', '', $tab);
					$lg = explode(']',$tab);

					$i = 0;
					for ($i=0;$i<sizeof($lg)-2;$i++) {

						$lg[$i] = substr($lg[$i],1);
						$lg[$i] = substr($lg[$i],1);
						$lg2 = explode(',',$lg[$i]);
					
						$tabScore[$i][0] = $lg2[0];
						$tabScore[$i][1] = $lg2[1];
						$tabScore[$i][2] = $lg2[2];
						$tabScore[$i][3] = $lg2[3];
						//print_r($tabScore);
						//echo"<br><br>";

					}
				
				}else{

					$tabScore = [[$user,"exemple",1000,"01-01-2000"]];

				}
				/*
				$tab = [
					["toto","minecraft",6924,"09-02-2022"],
					["admin","the division",5125,"31-07-2019"],
					["toto","the division",4,"16-09-2020"],
					["caki","lol",57,"02-07-2021"],
					["admin","fez",210,"12-02-2020"]
					
				];

				*/

			}

			//echo "<br>$user";
		?>


		<script>
			
			function triage() {

				var i = 0;
				var j = 0;
				var y = 0;
				var tabl = <?php echo json_encode($tabScore); ?>;
				var user = <?php echo json_encode($user); ?>;

				var long = tabl.length;
				while (j<long) {
					//console.log(j<long);
					//console.log(tabl[0][2]);
					for (i=0;i<(tabl.length-1);i++){
						if (parseInt(tabl[i][2]) > parseInt(tabl[i+1][2])) {
							y = 0;
							while (y < 4) {
								var inter = tabl[i+1][y];
								tabl[i+1][y] = tabl[i][y];
								tabl[i][y] = inter;
								y++;
							}
						}	
					}
					j++;
				}
				document.getElementById('tab').value=tabl;
				document.getElementById('nam').value=user;

				document.getElementById("form2").action = "principale.php";
				console.log(document.getElementById("form2").action);
				document.getElementById("form2").submit();

			}
			
			function triage2() {

				var i = 0;
				var j = 0;
				var y = 0;
				var tabl = <?php echo json_encode($tabScore); ?>;
				var user = <?php echo json_encode($user); ?>;

				//console.log(tabl[0][3]);
				for(j=0;j<tabl.length;j++) {
					for (i=0;i<(tabl.length-1);i++){

						var date1 = tabl[i][3].substr(6);
						var date2 = tabl[i+1][3].substr(6);
						y = 0;
						if (date1 > date2) {
							while (y < 4) {
								var inter = tabl[i+1][y];
								tabl[i+1][y] = tabl[i][y];
								tabl[i][y] = inter;
								y++;
							}
						}else{
							if (date1 == date2) {

								var date1 = tabl[i][3].substr(4,2);
								var date2 = tabl[i+1][3].substr(4,2);
								if (date1 > date2) {
									while (y < 4) {
										var inter = tabl[i+1][y];
										tabl[i+1][y] = tabl[i][y];
										tabl[i][y] = inter;
										y++;
									}
								}else{
									if (date1 == date2) {

										var date1 = tabl[i][3].substr(0,2);
										var date2 = tabl[i+1][3].substr(0,2);

										if (date1 > date2) {
											while (y < 4) {
												var inter = tabl[i+1][y];
												tabl[i+1][y] = tabl[i][y];
												tabl[i][y] = inter;
												y++;
											}
										}
									}
								}
							}
						}
					}
				}
				document.getElementById('tab').value=tabl;
				document.getElementById('nam').value=user;

				document.getElementById("form2").action = "principale.php";
				console.log(document.getElementById("form2").action);
				document.getElementById("form2").submit();

				
			}


			function Suppr(ligne) {
			
				console.log(ligne);
				var tabl = <?php echo json_encode($tabScore); ?>;
				if (tabl.length>1) {
				var user = <?php echo json_encode($user); ?>;
				var i = 0;
				for(i=ligne;i<tabl.length-1;i++) {

					tabl[i][0] = tabl[i+1][0];
					tabl[i][1] = tabl[i+1][1];
					tabl[i][2] = tabl[i+1][2];
					tabl[i][3] = tabl[i+1][3];

				}
				tabl.pop();
				console.log(tabl);
				document.getElementById('tab').value=tabl;
				document.getElementById('nam').value=user;

				document.getElementById("form2").action = "principale.php";
				console.log(document.getElementById("form2").action);
				document.getElementById("form2").submit();
				}else{
					alert("Il semblerait qu'il n'y a qu'un seul score, creez un nouveau avant de pouvoir en supprimer");
				}
			
			}


			function creation() {

				var tabl = <?php echo json_encode($tabScore); ?>;
				var user = <?php echo json_encode($user); ?>;
					
				var today = new Date();
				if (today.getDate() < 10) {
					var date = "0" + today.getDate()+'-';
				}else{
					var date = today.getDate()+'-';
				}
				if (today.getMonth()+1 <10) {
					var date = date + "0" + (today.getMonth()+1) +'-';
				}else{
					var date = date + (today.getMonth()+1) +'-';
				}
				var date = date + today.getFullYear();
				console.log(date);

				var m = prompt("entrez le nom du jeu","");

				var c = "a";
				while (isNaN(c)) {
					c = parseInt(prompt("entrez votre score sur : "+m,""));
				}
				alert(c);
				tabl.push([user, m, c, date]);
				console.log(tabl);
				
				document.getElementById('tab').value=tabl;
				document.getElementById('nam').value=user;

				document.getElementById("form2").action = "principale.php";
				console.log(document.getElementById("form2").action);
				document.getElementById("form2").submit();

			}

			function Modif(ligne) {

				var tabl = <?php echo json_encode($tabScore); ?>;
				var user = <?php echo json_encode($user); ?>;

				var m = tabl[ligne][1];
				if (confirm('Modifier le nom du jeu ?')) {
					var m = prompt("entrez le nouveau nom du jeu : ","");
				}
				tabl[ligne][1] = m;

				var c = tabl[ligne][2];
				if (confirm('Modifier le score de ce jeu?')) {
					c = parseInt(prompt("entrez votre score sur : "+m,""));
					while (isNaN(c)) {
						c = parseInt(prompt("entrez votre score sur : "+m,""));
					}
				}
				tabl[ligne][2] = c;

				var d = tabl[ligne][3];
				var today = new Date();
				if (confirm('A quelle date ?')) {
					var d = prompt("entrez une date : "+today.getDate()+"-"+(today.getMonth()+1)+"-"+today.getFullYear());
					while (isNaN(d.slice(0,2) || isNaN(d.slice(3,2) || isNaN(d.slice(5,4)) 
					{
						var d = prompt("entrez une date : "+today.getDate()+"-"+(today.getMonth()+1)+"-"+today.getFullYear());
					}
				}
				tabl[ligne][3] = d;

				document.getElementById('tab').value=tabl;
				document.getElementById('nam').value=user;

				document.getElementById("form2").action = "principale.php";
				console.log(document.getElementById("form2").action);
				document.getElementById("form2").submit();


			}
		</script>
	</form>


    <form id="InputValue">

		<div>
			<label for="creer">Creer un nouveau score : </label>
			<input type="button" id="creer" name="creer" onclick="creation()">
		</div>
		<div>
			<label for="rangerD">Trier par date : </label>
			<input type="button" id="rangerD" name="ranger" onclick="triage2()">
		</div>
		<div>
			<label for="rangerS">Trier par score : </label>
			<input type="button" id="rangerS" name="ranger" onclick="triage()" >
		</div>

	</form>
	<?php
	
		$i = 0;
		for ($i = 0;$i < sizeof($tabScore);$i++) {
			//echo $user.$tabScore[$i][0];
			if ($tabScore[$i][0] == $user) {
				echo '
				<form method="GET" action="" id="form3">
				<div id="Affichagebouton" style="border:1px solid #000000;">	
					<input type="button" id="delete'.$i.'" value="supprimer ce score" onclick="Suppr('.$i.')">
					<input type="button" id="modif'.$i.'" value ="modifier ce score" onclick="Modif('.$i.')">
				</div>
				<div id="AffichageTitre" style="border:1px solid #000000;">
					<p>'.$tabScore[$i][1].'</p>
				</div>
				<div id="AffichageScore" style="border:1px solid #000000;">
					<p>'.$tabScore[$i][2].'</p>
				</div>
				<div id="AffichageScore" style="border:1px solid #000000;">
					<p>'.$tabScore[$i][3].'</p>
				</div>
				<br>
				<br>
				</form>
				';
			}
		}
	
	?>
	
</body>
</html>