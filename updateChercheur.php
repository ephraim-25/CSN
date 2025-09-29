<?php
	require_once('session.php');
?>

<?php
	require_once('connexion.php');
	
	$id=$_POST['id'];
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$id_centre=$_POST['id_centre'];	
	$sexe=$_POST['sexe'];
	$lieu_naissance=$_POST['lieu_naissance'];
	$date_naissance=$_POST['date_naissance'];
	$titre_academique=$_POST['titre_academique'];
	$date_engagement=$_POST['date_engagement'];
	$anciennete=$_POST['anciennete'];
	$grade=$_POST['grade'];
	$matricule=$_POST['matricule'];
	$inventions=$_POST['inventions'];
	$champs_activites=$_POST['champs_activites'];
	$contribution_service_public=$_POST['contribution_service_public'];
	$societes_savantes=$_POST['societes_savantes'];
	$activites_scientifiques=$_POST['activites_scientifiques'];
	$publications=$_POST['publications'];
	$email=$_POST['email'];
	$telephone=$_POST['telephone'];
	$adresse=$_POST['adresse'];

		//Récuperer le nom de la photo envoyée
	$nomphoto= $_FILES['photo']['name'];	
	
		//Récuperer le nom du fichier image temporaire sur le serveur
	$imageTmp=$_FILES['photo']['tmp_name'];
	
		//Déplacer le fichier temporaire vers le dossier images de mon application
	move_uploaded_file($imageTmp,'../images/'.$nomphoto);
			
	if(!empty($nomphoto)){ // empty($nomphoto):$nomphoto est vide (photo non envoyée)
						  // !empty($nomphoto):$nomphoto non vide (photo envoyée)
		
		$requete="UPDATE CHERCHEUR SET nom=?,prenom=?,id_centre=?,sexe=?,lieu_naissance=?,date_naissance=?,date_engagement=?,
									   titre_academique=?,grade=?,matricule=?,inventions=?,champs_activites=?,contribution_service_public=?,
									   societes_savantes=?,activites_scientifiques=?,publications=?,email=?,telephone=?,adresse=?,photo=? 
									   where id=?";
		
		$param=array($nom,$prenom,$id_centre,$sexe,$lieu_naissance,$date_naissance,$titre_academique,$date_engagement,$anciennete,
					 $grade,$matricule,$inventions,$champs_activites,$contribution_service_public,$societes_savantes,
					 $activites_scientifiques,$publications,$email,$telephone,$adresse,$nomphoto,$id);		
	}
	else{ // photo non envoyée
		$requete="UPDATE CHERCHEUR SET nom=?,prenom=?,id_centre=?,sexe=?,lieu_naissance=?,date_naissance=?,date_engagement=?,
									   titre_academique=?,grade=?,matricule=?,inventions=?,champs_activites=?,contribution_service_public=?,
									   societes_savantes=?,activites_scientifiques=?,publications=?,email=?,telephone=?,adresse=? 
									   where id=?";

		$param=array($nom,$prenom,$id_centre,$sexe,$lieu_naissance,$date_naissance,$titre_academique,$date_engagement,$anciennete,
					 $grade,$matricule,$inventions,$champs_activites,$contribution_service_public,$societes_savantes,
					 $activites_scientifiques,$publications,$email,$telephone,$adresse,$id);	
	}
			
	$resultat = $con->prepare($requete);	
	$resultat->execute($param);	
	
	
	$msg= "Chercheur modifié avec succés";
	$url="pages/chercheurs.php?id_centre =$id_centre&index_CENTRE=$index_CENTRE&index_classe=$index_classe";
	header("location:../message.php?msg=$msg&color=v&url=$url");
	header("location:chercheurs.php");
?>

?>