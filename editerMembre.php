
<?php
	require_once('session.php');
	$id=$_GET['id'];
	require_once('connexion.php');
	
	$requete="select * from MEMBRE where id=$id";
	$resultat = $con->query($requete);
	$MEMBRE=$resultat->fetch();
	
	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Editer un Membre</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>		
		<div class="container">
			<br>
			
			<div class="panel panel-primary">
				<div class="panel-heading">Editer un Membre</div>
				<div class="panel-body">
					<form method="post" action="updateMembre.php" class="form" enctype="multipart/form-data">
					
						<div class="form-group">
							<label for="id" class="control-label" >
								id=<?php echo $MEMBRE['id']; ?>
							</label>
							<input type="hidden" name="id" 
									id="id" class="form-control" 
									value="<?php echo $MEMBRE['id']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="nom" class="control-label">nom & POST-nom</label>
							<input type="text" name="nom" id="nom" class="form-control"
									value="<?php echo $MEMBRE['nom']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="fonction" class="control-label">fonction</label>
							<input type="text" name="fonction" id="fonction" class="form-control"
									value="<?php echo $MEMBRE['fonction']; ?>"/>
						</div>

						<div class="form-group">
							<label for="institution" class="control-label">CENTRE/INSTITUTS</label>
							<input type="text" name="institution" id="institution" class="form-control"
									value="<?php echo $MEMBRE['institution']; ?>"/>
						</div>

						<div class="form-group">
							<label for="telephone" class="control-label">telephone</label>
							<input type="text" name="telephone" id="telephone" class="form-control"
									value="<?php echo $MEMBRE['telephone']; ?>"/>
						</div>

						<div class="form-group">
							<label for="email" class="control-label">email</label>
							<input type="text" name="email" id="email" class="form-control"
									value="<?php echo $MEMBRE['email']; ?>"/>
						</div>
						
						<button type="submit" class="btn btn-primary">Enregistrer</button>
							
					</form>
				</div>
			</div>
			
			
				
		</div>
	</body>
</html>



