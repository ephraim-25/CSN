<?php
	require_once('session.php');
?>

<?php

	require_once('connexion.php');
	
	$nom=$_POST['nom'];
	$fonction=$_POST['fonction'];
	$institution=$_POST['institution'];
	$telephone=$_POST['telephone'];
	$email=$_POST['email'];	
	
	$requete="INSERT into MEMBRE(nom,fonction,institution,telephone,email) VALUES(?,?,?,?,?)";	
			
	$param=array($nom,$fonction,$institution,$telephone,$email);	
	
	$resultat = $con->prepare($requete);
	
	$resultat->execute($param);	
		
	header("location:membres.php");
	
?>