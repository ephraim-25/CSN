
<?php
	require_once('connexion.php');
	
	
	if(isset($_POST['email']))
	    
		$email=$_POST['email'];
	
	else
	    
		$email="";
	
	$requete1="select * from utilisateur where email='$email'";
	
	$resultat1 = $con->query($requete1);
	
	
	if($user=$resultat1->fetch()){
	    
		$id=$user['id'];
		
		$pwd="0000";
		
		$requete="update utilisateur set pwd=MD5(?) where id=?";	
		
		$param=array($pwd,$id);	
		
		$resultat = $con->prepare($requete);	
		
		$resultat->execute($param);
	
		$to = $user['email'];
		
		$subject = "INITIALISATION DE MOT DE PASSE (Poste HP)";
		
		$txt = "Votre nouveau mot de passe de gesStag est :$pwd";
		
		$headers = "From: GesStag" . "\r\n" ."CC: lahcenabousalih@gmail.com";
		
		mail($to,$subject,$txt,$headers);
		
		header("location:confirmationResetpwd.php");
	
	}else{
	    
		$_SESSION['erreurlogin']="<strong>Erreur!</strong> L'email est incorrecte!!!";
		
         header("Location:initialiserpwd.php");
	}	
			
	
?>