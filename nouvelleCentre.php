<?php
	require_once('session.php');
	
	require_once('connexion.php');
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouveau Centre/Institut</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>		
		<div class="container">
			<br>
			
			<div class="panel panel-primary">
				<div class="panel-heading">Nouvelle Centre/Institut</div>
				<div class="panel-body">
					<form method="post" action="insertCentre.php" class="form" enctype="multipart/form-data">
					
						<div class="form-group">
							<label for="nom_centre" class="control-label">CENTRES/INSTITUTS</label>
							<input type="text" name="nom_centre" id="nom_centre" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="niveau" class="control-label">NIVEAU</label>
							<input type="text" name="niveau" id="niveau" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="adresse_contacts" class="control-label">ADRESSE DE CONTACTS</label>
							<input type="text" name="adresse_contacts" id="adresse_contacts" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="ville" class="control-label">VILLE</label>
							<input type="text" name="ville" id="ville" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="province" class="control-label">PROVINCE</label>
							<input type="text" name="province" id="province" class="form-control"/>
						</div>	
								
						<button type="submit" class="btn btn-primary">Enregistrer</button>
							
					</form>
				</div>
			</div>
		</div>
	</body>
</html>