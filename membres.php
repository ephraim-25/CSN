<?php
	require_once('session.php');
?>

<?php
	
	require_once('connexion.php');
	
	if(isset($_GET['motCle']))
		$mc=$_GET['motCle'];
	else
		$mc="";
	
	if(isset($_GET['fonction']))
		$fonction=$_GET['fonction'];
	else
		$fonction="all";
		
	if(isset($_GET['size']))
		$size=$_GET['size'];
	else
		$size=20;
		
	if(isset($_GET['page']))
		$page=$_GET['page'];
	else
		$page=1;
			
	$offset=($page-1)*$size;
	
	if($fonction=="all"){// TOUS LES fonctionS
		$resultat1 = $con->query("SELECT * FROM MEMBRE
									WHERE  nom like '%$mc%' 
									ORDER BY id
									LIMIT $size
									OFFSET $offset");

		$resultat2 = $con->query("select count(*) as nbrMembre
									from MEMBRE 
									where nom like '%$mc%'");
	}else{
		$resultat1 = $con->query("SELECT * FROM MEMBRE
									WHERE  nom like '%$mc%'
									AND fonction='$fonction'
									ORDER BY id
									LIMIT $size
									OFFSET $offset");

		$resultat2 = $con->query("select count(*) as nbrMembre 
									from MEMBRE 
									where nom like '%$mc%'
									AND fonction='$fonction'");
	}
	
	
	$nbr=$resultat2->fetch();
	
	$nbrM=$nbr['nbrMembre'];
	
	$reste=$nbrM % $size; //l'operateur % (modulo) retourne le reste de la 
						// devision euclidienne de $nbrCE sur $size
	if($reste==0)
		$nbrPage=$nbrM/$size;
	else
		$nbrPage=floor($nbrM/$size)+1;// floor retourne la partie entière d'un nombre 
										// decimale
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Gestion des Membres</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>
		<?php include('entete.php');?>
			
		<div class="container">
			<div class="panel panel-success espace60">
				<div class="panel-heading">Rechercher des Membres</div>
				<div class="panel-body">
					<form method="get" action="membres.php" class="form-inline">
						<div class="form-group">													
							
							<input type="text" name="motCle" 
									placeholder="Taper un mot clé"
									id="motCle" class="form-control" 
									value="<?php echo $mc; ?>"/>
							
							<label for="fonction" class="control-label">fonction</label>
							<select name="fonction" id="fonction" class="form-control"
									onChange="this.form.submit();">
								<option value="all" <?php echo $fonction=="all"?"selected":"" ?>>Tous les fonctions</option>
								<option value="pr" <?php echo $fonction=="pr"?"selected":"" ?>>PRESidENT</option>
								<option value="dg" <?php echo $fonction=="dg"?"selected":"" ?>>DG</option>
								<option value="sp" <?php echo $fonction=="sp"?"selected":"" ?>>SP</option>
								<option value="sg" <?php echo $fonction=="sg"?"selected":"" ?>>SG</option>
								<option value="de" <?php echo $fonction=="de"?"selected":"" ?>>Delegué</option>
								<option value="dg ai" <?php echo $fonction=="dg ai"?"selected":"" ?>>DG ai</option>
								<option value="rep" <?php echo $fonction=="rep"?"selected":"" ?>>Représetant</option>
							</select>

							<button type="submit" class="btn btn-success">
								<i class="glyphicon glyphicon-search"></i>
								Chercher...
							</button>
							
							&nbsp&nbsp&nbsp
							<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
								<a class="btn btn-success" href="nouveauMembre.php">Nouveau Membre</a>
							<?php } ?>	
						</div>
							
					</form>
				</div>
			</div>
			<div class="panel panel-primary ">
				<div class="panel-heading">Liste des Membres (<?php echo $nbrM ?>&nbsp Membres) </div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>id</th>
								<th>nom & POST-nom</th>
								<th>fonction</th>
								<th>institution</th>
								<th>telephone</th>	
								<th>email</th>							
								 <?php if($_SESSION['utilisateur']['role']=="ADMIN") {?> 
									<th>ACTIONS</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php while($MEMBRE=$resultat1->fetch()){?>
								<tr>
									<td><?php echo $MEMBRE['id'] ?></td>
									<td><?php echo $MEMBRE['nom'] ?></td>
									<td><?php echo $MEMBRE['fonction'] ?></td>
									<td><?php echo $MEMBRE['institution'] ?></td>
									<td><?php echo $MEMBRE['telephone'] ?></td>
									<td><?php echo $MEMBRE['email'] ?></td>
									
									<td>
										<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
											<!--  Action Editer une MEMBRE -->
											<a href="editerMembre.php?id=<?php echo $MEMBRE['id'] ?>">
												<span class="glyphicon glyphicon-pencil"></span>
											</a>
											
											&nbsp &nbsp
											<!--  Action Supprimer une MEMBRE -->
											<a Onclick="return confirm('Etes vous sur de vouloir supprimer ce Membre?')" 
												href="supprimerMembre.php?id=<?php echo $MEMBRE['id'] ?>">
												<span class="glyphicon glyphicon-trash"></span>
											</a>
																						
										<?php } ?>
										
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<div>
						<ul class="nav nav-pills">
							
							<?php for($i=1;$i<=$nbrPage;$i++){ ?>
								<li class="<?php if($i==$page) echo 'active' ?>">
									<a href="membres.php?page=<?php echo $i ?>
										&motCle=<?php echo $mc ?>
										&size=<?php echo $size ?>">
										Page <?php echo $i ?>
									</a>
								</li>
							<?php } ?>	
						</ul>
					</div>
					
				</div>				
			</div>	
			
		</div>
	</body>
</html>