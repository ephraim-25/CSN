<?php
	require_once('session.php');
?>

<?php

	require_once('connexion.php');
	
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$id_centre=$_POST['id_centre'];

	$sexe=$_POST['sexe'];

	$lieu_naissance=$_POST['lieu_naissance'];
	$date_naisance=$_POST['date_naissance'];
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
		
	$nomphoto= $_FILES['photo']['name'];	
	$imageTmp=$_FILES['photo']['tmp_name'];
	move_uploaded_file($imageTmp,'../images/'.$nomphoto);
	
	$requete="INSERT into CHERCHEUR(nom,prenom,id_centre,sexe,lieu_naissance,date_naissance,titre_academique,date_engagement,
									anciennete,grade,matricule,inventions,champs_activites,contribution_service_public,
									societes_savantes,activites_scientifiques,publications,email,telephone,adresse,photo) 
									VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";	
	$resultat = $con->prepare($requete);			
	$param=array($nom,$prenom,$id_centre,$sexe,$lieu_naissance,$date_naisance,$titre_academique,$date_engagement,
				 $anciennete,$grade,$matricule,$inventions,$champs_activites,$contribution_service_public,
				 $societes_savantes,$activites_scientifiques,$publications,$email,$telephone,$adresse,$nomphoto);			
	$resultat->execute($param);	
		
	
	$msg= "Chercheur est ajouté avec succès";
	$url="chercheurs.php";		
	header("location:../message.php?msg=$msg&color=v&url=$url");
	header("location: chercheurs.php");
?>