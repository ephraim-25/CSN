<?php
	require_once('session.php');
?>

<?php

	require_once('connexion.php');
	
	$nom=$_POST['nom_centre'];
	$niveau=$_POST['niveau'];
	$adresse_contacts=$_POST['adresse_contacts'];
	$ville=$_POST['ville'];
	$province=$_POST['province'];	
	
	$requete="INSERT into CENTRE(nom_centre,niveau,adresse_contacts,ville,province) VALUES(?,?,?,?,?)";	
			
	$param=array($nom,$niveau,$adresse_contacts,$ville,$province);	
	
	$resultat = $con->prepare($requete);
	
	$resultat->execute($param);	
		
	header("location:centres.php");
	
?>