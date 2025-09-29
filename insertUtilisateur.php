<?php
	//require_once('session.php');
?>

<?php
	session_start();
	require_once('connexion.php');
	
	if(isset($_POST['login']))
		$login=$_POST['login'];
	else
		$login="";
	
	if(isset($_POST['pwd1']))
		$pwd1=$_POST['pwd1'];
	else
		$pwd1="";
			
	if(isset($_POST['pwd2']))
		$pwd2=$_POST['pwd2'];
	else
		$pwd2="";
	
	if(isset($_POST['email']))
		$email=$_POST['email'];
	else
		$email="";

	$role='CHERCHEUR';
	
	$etat=0;
	
	$requete="select * from utilisateur where email=?";		
	$param=array($email);	
	$resultat = $con->prepare($requete);		
	$resultat->execute($param);	
	
	if($user=$resultat->fetch()){
		$_SESSION['erreuremailExiste']="<strong>Erreur!</strong> Cette adresse email existe deja!!!";
         header("Location:nouvelUtilisateur.php");
	}else{
		$requete="insert into UTILISATEUR(login,role,pwd,email,etat) values(?,?,MD5(?),?,?)"; 	
		$resultat = $con->prepare($requete);			
		$param=array($login,$role,$pwd1,$email,$etat);
		$resultat->execute($param);
		
		$to = "acheccircsn@gmail.com";
		$subject = "Activation d'un compte";
		$txt = "Merci d'activer mon compte :$login";
		$headers = "From: Gestion_Acheccir" . "\r\n" .	"CC: acheccircsn@gmail.com";

		mail($to,$subject,$txt,$headers);

		session_destroy();
		header("location:confirmationCompte.php?login=$login&email=$email");
	}
?>