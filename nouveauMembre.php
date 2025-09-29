<?php
	require_once('session.php');
	
	require_once('connexion.php');
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouveau Membre</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>		
		<div class="container">
			<br>
			
			<div class="panel panel-primary">
				<div class="panel-heading">Nouveau Membre</div>
				<div class="panel-body">
					<form method="post" action="insertMembre.php" class="form" enctype="multipart/form-data">
					
						<div class="form-group">
							<label for="nom" class="control-label">nom & POST-nom</label>
							<input type="text" name="nom" id="nom" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="fonction" class="control-label">fonction</label>
							<input type="text" name="fonction" id="fonction" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="institution" class="control-label">CENTRE/INSTITUT</label>
							<input type="text" name="institution" id="institution" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="telephone" class="control-label">telephone</label>
							<input type="text" name="telephone" id="telephone" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="email" class="control-label">email</label>
							<input type="text" name="email" id="email" class="form-control"/>
						</div>	
								
						<button type="submit" class="btn btn-primary">Enregistrer</button>
							
					</form>
				</div>
			</div>
			
			
				
		</div>
	</body>
</html>



