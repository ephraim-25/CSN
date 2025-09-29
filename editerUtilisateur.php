<?php
	require_once('session.php');
	if(isset($_SESSION['erreuremailExiste'])){
		$erreuremailExiste=$_SESSION['erreuremailExiste'];
		$_SESSION['erreuremailExiste']="";
	}else{
		$erreuremailExiste="";
		
	}
?>
<?php
	
	$id=$_GET['id'];
	require_once('connexion.php');
	$requete="select * from utilisateur where id=$id";
	$resultat = $con->query($requete);
	$user=$resultat->fetch();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Editer un utilisateur</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monStyle.css">
		<script src="../js/jquery-3.3.1.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</head>
	<body>		
		<div class="container col-lg-4 col-md-offset-4">
			<br>
			
			<div class="panel panel-primary">
				<div class="panel-heading">Editer un utilisateur</div>
				<div class="panel-body">
					<form method="post" action="updateUtilisateur.php" class="form">
					
						<div class="form-group">
							<label for="id" class="control-label" >
								id=<?php echo $user['id']; ?>
							</label>
							<input type="hidden" name="id" 
									id="id" class="form-control" 
									value="<?php echo $user['id']; ?>"/>
						</div>
						
						<div class="form-group">
							<label for="login" class="control-label">login</label>
							<input type="text" name="login" id="login" class="form-control"
									value="<?php echo $user['login']; ?>"/>
						</div>
						<div class="form-group">
							<label for="email" class="control-label">email </label>
							<input type="text" name="email" id="email" class="form-control"
									value="<?php echo $user['email']; ?>"/>
						</div>
						<?php
								if($erreuremailExiste!=""){?>			
									<div class="alert alert-danger alert-dismissible">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<?php echo $erreuremailExiste ?>
									</div>			
						<?php 	}	?>	
						
							<!---- **************************  -->
						<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
							
							<div class="form-group">
								<label for="role" class="control-label">role</label>
								<select name="role" id="role" class="form-control">
										<option value="ADMIN" 
											<?php echo $user['role']=="ADMIN"?"selected":"" ?>>									
											ADMIN
										</option>	
										<option value="CHERCHEUR" 
											<?php echo $user['role']=="CHERCHEUR"?"selected":"" ?>>									
											CHERCHEUR
										</option>										

								</select>
							</div>
						<?php } ?>
					<!---- **************************  -->
												
						<input type="submit" class="btn btn-primary" value="Enregistrer"/>
							&nbsp &nbsp	&nbsp &nbsp
						<a href="editpwd.php">Changer le mot de passe</a>	
					</form>
				</div>
			</div>
			
			
				
		</div>
	</body>
</html>



