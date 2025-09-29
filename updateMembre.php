<?php
	require_once('session.php');
?>

<?php
	require_once('connexion.php');
	
	$id=$_POST['id'];
	$nom=$_POST['nom'];
	$fonction=$_POST['fonction'];
	$institution=$_POST['institution'];
	$telephone=$_POST['telephone'];
	$email=$_POST['email'];	
	
	$requete="UPDATE MEMBRE SET nom=?,fonction=?,institution=?,telephone=?,email=? where id=?";
	$param=array($nom,$fonction,$institution,$telephone,$email,$id);		
	
	$resultat = $con->prepare($requete);	
	$resultat->execute($param);	
	
	header("location:membres.php");

?>