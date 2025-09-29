<?php
	require_once('session.php');
?>

<?php
	require_once('connexion.php');
	
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else
		$id=0;
	
	if(isset($_POST['login']))
		$login=$_POST['login'];
	else
		$login="";
	
	if(isset($_POST['email']))
		$email=$_POST['email'];
	else
		$email="";
	
	if(isset($_POST['role']))
		$role=$_POST['role'];
	else
		$role="";
	
	if(isset($_POST['etat']))
		$etat=$_POST['etat'];
	else
		$etat="";
	/*
	if(isset($_POST['pwd1']))
		$pwd1=$_POST['pwd1'];
	else
		$pwd1="";
			
	if(isset($_POST['pwd2']))
		$pwd2=$_POST['pwd2'];
	else
		$pwd2="";
	*/
	$requete="select * from utilisateur where email=? and id<>?";		
	$param=array($email,$id);	
	$resultat = $con->prepare($requete);		
	$resultat->execute($param);
	
	//$requete="select * from utilisateur where email='$email' and id<>$id";
	//$resultat = $con->query($requete);
	//echo $requete;
	
	if($user=$resultat->fetch()){
		$_SESSION['erreuremailExiste']="<strong>Erreur!</strong> Cette adresse email existe deja!!!";
        header("Location:editerUtilisateur.php?id=$id");
	}else{
		if($_SESSION['user']['role']=="ADMIN") {
			$requete="update utilisateur 
				set login=?,
				role=?,
				email=?,
				etat=?
				where id=?";	
			$param=array($login,$role,$email,$etat,$id);
			$resultat = $con->prepare($requete);		
			$resultat->execute($param);	
			header("location:utilisateurs.php");
			//header('Location:'.$_SERVER[HTTP_REFERER]);	
		}else{
			$requete="update utilisateur 
				set login=?,
				email=?
				where id=?";	
			$param=array($login,$email,$id);
			$resultat = $con->prepare($requete);		
			$resultat->execute($param);	
			header("location:login.php");	
		}
	}
?>