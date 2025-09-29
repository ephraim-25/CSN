<?php
	require_once('connexion.php');
	session_start();
	
	$login=$_POST['login'];
	$pwd=$_POST['pwd'];
	
	
	$requete="select * from utilisateur where login=? and pwd=MD5(?)";
		
	$param=array($login,$pwd);	
	$resultat = $con->prepare($requete);		
	$resultat->execute($param);	
	
	if($user=$resultat->fetch()){
		
			if($user['etat']==1){
				$_SESSION['utilisateur']=$user;
				//header("Location:../index.php");
				header("Location:../pages/dashboard.php");
			}else{
			
				$_SESSION['erreurlogin']="<strong>Erreur!</strong> Votre compte est désactivé.<br> veuillez contacter l'administrateur!!!";
				header("Location:login.php");
			}
    }else{
		 $_SESSION['erreurlogin']='<strong>Erreur!</strong> login ou mot de passe incorrect!!!';
         header("Location:login.php");
    } 
	
?>