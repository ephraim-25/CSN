<?php
	require_once('session.php');
?>

<?php
	require_once('connexion.php');
	
	$id=$_POST['id'];
	$nom=$_POST['nom_centre'];
	$niveau=$_POST['niveau'];
	$adresse_contacts=$_POST['adresse_contacts'];
	$ville=$_POST['ville'];
	$province=$_POST['province'];	
	
	$requete="UPDATE CENTRE SET nom_centre=?,niveau=?,adresse_contacts=?,ville=?,province=? where id=?";
	$param=array($nom,$niveau,$adresse_contacts,$ville,$province,$id);		
	
	$resultat = $con->prepare($requete);	
	$resultat->execute($param);	
	
	header("location:centres.php");

?>