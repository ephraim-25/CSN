
<?php
	require_once('session.php');
	$id=$_GET['id'];
	require_once('connexion.php');
	
	$requete="select * from CHERCHEUR where id=$id";
	$resultat = $con->query($requete);
	$CHERCHEUR=$resultat->fetch();
	
	$requetece="select * from CENTRE";
	$resultatce = $con->query($requetece);
	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Editer un chercheur</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>		
		<div class="container">
			<br>
			
			<div class="panel panel-primary">
				<div class="panel-heading">EDITER UN CHERCHEUR</div>
				<div class="panel-body">
					<form method="post" action="updateChercheur.php" class="form" enctype="multipart/form-data">
					
						<div class="form-group">
							<label for="id" class="control-label" >
								id=<?php echo $CHERCHEUR['id']; ?>
							</label>
							<input type="hidden" name="id" 
									id="id" class="form-control" 
									value="<?php echo $CHERCHEUR['id']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="nom" class="control-label">NOM & POST-NOM</label>
							<input type="text" name="nom" id="nom" class="form-control"
									value="<?php echo $CHERCHEUR['nom']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="prenom" class="control-label">PRENOM</label>
							<input type="text" name="prenom" id="prenom" 
							class="form-control"
							value="<?php echo $CHERCHEUR['prenom'] ?>"/>
						</div>

						<div class="form-group">
							<label for="id_centre" class="control-label">CENTRE/INSTITUT</label>
							<select name="id_centre" id="id_centre" class="form-control">
								<?php while($CENTRE=$resultatf->fetch()){ ?>
									<option value="<?php echo $CENTRE['id']?>" 
										<?php echo $CHERCHEUR['id_centre']==$CENTRE['id']?"selected":"" ?>>									
										<?php echo $CENTRE['nom_centre']?>
									</option>									
								<?php } ?>
							</select>
						</div>
						
						<!---- **************************  -->
						<label class="control-label">SEXE</label>
						<div class="radio">							
							<label><input type="radio" name="sexe" value="F" <?php echo $CHERCHEUR['sexe']=="F"?"checked":""?>/> F &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="sexe" value="M" <?php echo $CHERCHEUR['sexe']=="M"?"checked":""?>/> M </label><br/>							
						</div>
						<!---- **************************  -->

						<div class="form-group">
							<label for="lieu_naissance" class="control-label">LIEU DE NAISSANCE</label>
							<input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control"
									value="<?php echo $CHERCHEUR['lieu_naissance']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="date_naissance" class="control-label">DATE DE NAISSANCE</label>
							<input type="text" name="date_naissance" id="date_naissance" 
							class="form-control"
							value="<?php echo $CHERCHEUR['date_naissance'] ?>"/>
						</div>

						<div class="form-group">
							<label for="titre_academique" class="control-label">TITRE ACADEMIQUE</label>
							<input type="text" name="titre_academique" id="titre_academique" class="form-control"
									value="<?php echo $CHERCHEUR['titre_academique']; ?>"/>
						</div>

						<div class="form-group">
							<label for="date_engagement" class="control-label">DATE ENGAGEMENT</label>
							<input type="text" name="date_engagement" id="date_engagement" 
							class="form-control"
							value="<?php echo $CHERCHEUR['date_engagement'] ?>"/>
						</div>

						<div class="form-group">
							<label for="anciennete" class="control-label">ANCIENNETE</label>
							<input type="number" name="anciennete" id="anciennete" 
							class="form-control"
							value="<?php echo $CHERCHEUR['anciennete'] ?>"/>
						</div>

						<div class="form-group">
							<label for="grade" class="control-label">GRADE</label>
							<input type="text" name="grade" id="grade" class="form-control"
									value="<?php echo $CHERCHEUR['grade']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="matricule" class="control-label">MATRICULE</label>
							<input type="text" name="matricule" id="matricule" 
							class="form-control"
							value="<?php echo $CHERCHEUR['matricule'] ?>"/>
						</div>

						<div class="form-group">
							<label for="inventions" class="control-label">INVENTIONS / INNOVATIONS</label>
							<input type="text" name="inventions" id="inventions" 
							class="form-control"
							value="<?php echo $CHERCHEUR['inventions'] ?>"/>
						</div>
										
						<div class="form-group">
							<label for="champs_activites" class="control-label">DOMAINES DE RECHERCHE</label>
							<input type="text" name="champs_activites" id="champs_activites" 
							class="form-control"
							value="<?php echo $CHERCHEUR['champs_activites'] ?>"/>
						</div>

						<div class="form-group">
							<label for="contribution_service_public" class="control-label">CONTRIBUTION AU SERVICE PUBLIC</label>
							<input type="text" name="contribution_service_public" id="contribution_service_public" class="form-control"
									value="<?php echo $CHERCHEUR['contribution_service_public']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="societes_savantes" class="control-label">SOCIETES SAVANTES</label>
							<input type="text" name="societes_savantes" id="societes_savantes" 
							class="form-control"
							value="<?php echo $CHERCHEUR['societes_savantes'] ?>"/>
						</div>

						<div class="form-group">
							<label for="activites_scientifiques" class="control-label">ACTIVITES SCIENTIFIQUES</label>
							<input type="text" name="activites_scientifiques" id="activites_scientifiques" class="form-control"
									value="<?php echo $CHERCHEUR['activites_scientifiques']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="publications" class="control-label">PUBLICATIONS</label>
							<input type="text" name="publications" id="publications" 
							class="form-control"
							value="<?php echo $CHERCHEUR['publications'] ?>"/>
						</div>

						<div class="form-group">
							<label for="email" class="control-label">EMAIL</label>
							<input type="text" name="email" id="email" class="form-control"
									value="<?php echo $CHERCHEUR['email']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="telephone" class="control-label">TELEPHONE</label>
							<input type="text" name="telephone" id="telephone" 
							class="form-control"
							value="<?php echo $CHERCHEUR['telephone'] ?>"/>
						</div>

						<div class="form-group">
							<label for="adresse" class="control-label">ADRESSE</label>
							<input type="text" name="adresse" id="adresse" class="form-control"
									value="<?php echo $CHERCHEUR['adresse']; ?>"/>
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



