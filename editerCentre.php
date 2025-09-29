
<?php
	require_once('session.php');
	$id=$_GET['id'];
	require_once('connexion.php');
	
	$requete="select * from CENTRE where id=$id";
	$resultat = $con->query($requete);
	$CENTRE=$resultat->fetch();
	
	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Editer un Centre/Institut</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>		
		<div class="container">
			<br>
			
			<div class="panel panel-primary">
				<div class="panel-heading">Editer un Centre/Institut</div>
				<div class="panel-body">
					<form method="post" action="updateCentre.php" class="form" enctype="multipart/form-data">
					
						<div class="form-group">
							<label for="id" class="control-label" >
								id=<?php echo $CENTRE['id']; ?>
							</label>
							<input type="hidden" name="id" 
									id="id" class="form-control" 
									value="<?php echo $CENTRE['id']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="nom_centre" class="control-label">CENTRE/INSTITUT</label>
							<input type="text" name="nom_centre" id="nom_centre" class="form-control"
									value="<?php echo $CENTRE['nom_centre']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="niveau" class="control-label">NIVEAU</label>
							<input type="text" name="niveau" id="niveau" class="form-control"
									value="<?php echo $CENTRE['niveau']; ?>"/>
						</div>

						<div class="form-group">
							<label for="adresse_contacts" class="control-label">ADRESSE DE CONTACTS</label>
							<input type="text" name="adresse_contacts" id="adresse_contacts" class="form-control"
									value="<?php echo $CENTRE['adresse_contacts']; ?>"/>
						</div>

						<div class="form-group">
							<label for="ville" class="control-label">VILLE</label>
							<input type="text" name="ville" id="ville" class="form-control"
									value="<?php echo $CENTRE['ville']; ?>"/>
						</div>

						<div class="form-group">
							<label for="province" class="control-label">PROVINCE</label>
							<input type="text" name="province" id="province" class="form-control"
									value="<?php echo $CENTRE['province']; ?>"/>
						</div>
						
						<button type="submit" class="btn btn-primary">Enregistrer</button>
							
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>