<?php
	require_once('session.php');
	
	require_once('connexion.php');
	$requetece="select * from CENTRE";
	$resultatce = $con->query($requetece);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Nouveau chercheur</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>		
		<div class="container">
			<br>
			
			<div class="panel panel-primary">
				<div class="panel-heading">FORMULAIRE DE CHERCHEUR</div>
				<div class="panel-body">
					<form method="post" action="insertChercheur.php" class="form" enctype="multipart/form-data">
					
						<div class="form-group">
							<label for="nom" class="control-label">NOM & POST-NOM</label>
							<input type="text" name="nom" id="nom" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="prenom" class="control-label">PRENOM</label>
							<input type="text" name="prenom" id="prenom" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="id_centre" class="control-label">centres/INSTITUTS</label>
							<select name="id_centre" id="id_centre" class="form-control">
								<?php while($CENTRE=$resultatce->fetch()){ ?>
									<option value="<?php echo $CENTRE['id']?>">
										<?php echo $CENTRE['nom_centre']?>
									</option>
								<?php } ?>
							</select>
						</div>
						
						<!---- **************************  -->
						<label class="control-label">SEXE</label>
						<div class="radio">							
							<label><input type="radio" name="sexe" value="F" checked/> F </label><br/>
							<label><input type="radio" name="sexe" value="M"/> M </label><br/>							
						</div>
						<!---- **************************  -->
						
						<div class="form-group">
							<label for="lieu_naissance" class="control-label">LIEU DE NAISSANCE</label>
							<input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="date_naissance" class="control-label">DATE DE NAISSANCE</label>
							<input type="date" name="date_naissance" id="date_naissance" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="titre_academique" class="control-label">TITRE ACADEMIQUE</label>
							<input type="text" name="titre_academique" id="titre_academique" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="date_engagement" class="control-label">DATE D'ENGAGEMENT</label>
							<input type="date" name="date_engagement" id="date_engagement" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="anciennete" class="control-label">ANCIENNETE</label>
							<input type="number" name="anciennete" id="anciennete" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="grade" class="control-label">GRADE</label>
							<input type="text" name="grade" id="grade" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="matricule" class="control-label">MATRICULE</label>
							<input type="text" name="matricule" id="matricule" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="inventions" class="control-label">INVENTIONS / INNOVATIONS</label>
							<input type="text" name="inventions" id="inventions" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="champs_activites" class="control-label">DOMAINES DE RECHERCHE</label>
							<input type="text" name="champs_activites" id="champs_activites" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="contribution_service_public" class="control-label">CONTRIBUTION AU SERVICE PUBLIC</label>
							<input type="text" name="contribution_service_public" id="contribution_service_public" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="societes_savantes" class="control-label">SOCIETES SAVANTES</label>
							<input type="text" name="societes_savantes" id="societes_savantes" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="activites_scientifiques" class="control-label">ACTIVITES SCIENTIFIQUES</label>
							<input type="text" name="activites_scientifiques" id="activites_scientifiques" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="publications" class="control-label">PUBLICATIONS</label>
							<input type="text" name="publications" id="publications" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="email" class="control-label">EMAIL</label>
							<input type="text" name="email" id="email" class="form-control"/>
						</div>
						
						<div class="form-group">
							<label for="telephone" class="control-label">TELEPHONE</label>
							<input type="text" name="telephone" id="telephone" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="adresse" class="control-label">ADRESSE</label>
							<input type="text" name="adresse" id="adresse" class="form-control"/>
						</div>

						<div class="form-group">
							<label for="photo" class="control-label">AVATAR :</label>
							<input type="file" name="photo" id="photo"/>
						</div>						
						<button type="submit" class="btn btn-primary">Enregistrer</button>
							
					</form>
				</div>
			</div>
		</div>
	</body>
</html>



