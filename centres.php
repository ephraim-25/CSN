<?php
	require_once('session.php');
?>

<?php
	
	require_once('connexion.php');
	
	if(isset($_GET['motCle']))
		$mc=$_GET['motCle'];
	else
		$mc="";
	
	if(isset($_GET['niveau']))
		$niveau=$_GET['niveau'];
	else
		$niveau="all";
		
	if(isset($_GET['size']))
		$size=$_GET['size'];
	else
		$size=20;
		
	if(isset($_GET['page']))
		$page=$_GET['page'];
	else
		$page=1;
			
	$offset=($page-1)*$size;
	
	if($niveau=="all"){// TOUS LES niveauX
		$resultat1 = $con->query("SELECT * FROM CENTRE
									WHERE  nom_centre like '%$mc%' 
									ORDER BY id
									LIMIT $size
									OFFSET $offset");

		$resultat2 = $con->query("select count(*) as nbrCENTRE 
									from CENTRE 
									where nom_centre like '%$mc%'");
	}else{
		$resultat1 = $con->query("SELECT * FROM CENTRE
									WHERE  nom_centre like '%$mc%'
									AND niveau='$niveau'
									ORDER BY id
									LIMIT $size
									OFFSET $offset");

		$resultat2 = $con->query("select count(*) as nbrCENTRE 
									from CENTRE 
									where nom_centre like '%$mc%'
									AND niveau='$niveau'");
	}
	
	
	$nbr=$resultat2->fetch();
	
	$nbrCE=$nbr['nbrCENTRE'];
	
	$reste=$nbrCE % $size; //l'operateur % (modulo) retourne le reste de la 
						// devision euclidienne de $nbrCE sur $size
	if($reste==0)
		$nbrPage=$nbrCE/$size;
	else
		$nbrPage=floor($nbrCE/$size)+1;// floor retourne la partie entière d'un nombre 
										// decimale
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Gestion des centres/Instituts</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>
		<?php include('entete.php');?>
			
		<div class="container">
			<div class="panel panel-success espace60">
				<div class="panel-heading">RECHERCHER LES CENTRES / INSTITUTS</div>
				<div class="panel-body">
					<form method="get" action="centres.php" class="form-inline">
						<div class="form-group">													
							
							<input type="text" name="motCle" 
									placeholder="Taper un mot clé"
									id="motCle" class="form-control" 
									value="<?php echo $mc; ?>"/>
							
							<label for="niveau" class="control-label">NIVEAU</label>
							<select name="niveau" id="niveau" class="form-control"
									onChange="this.form.submit();">
								<option value="all" <?php echo $niveau=="all"?"selected":"" ?>>Tous les niveaux</option>
								<option value="CEN" <?php echo $niveau=="c"?"selected":"" ?>>Central</option>
								<option value="PRO" <?php echo $niveau=="p"?"selected":"" ?>>Provincial</option>
							</select>

							<button type="submit" class="btn btn-success">
								<i class="glyphicon glyphicon-search"></i>
								Chercher...
							</button>
							
							&nbsp&nbsp&nbsp
							<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
								<a class="btn btn-success" href="nouvelleCENTRE.php">Nouveau Centre/Institut</a>
							<?php } ?>	
						</div>
							
					</form>
				</div>
			</div>
			<div class="panel panel-primary ">
				<div class="panel-heading">LISTES DES CENTRES / INSTITUTS (<?php echo $nbrCE ?>&nbsp Centres/Instituts) </div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>CENTRE/INSTITUTS</th>
								<th>NIVEAU</th>
								<th>ADRESSE DE CONTACTS</th>
								<th>VILLE</th>	
								<th>PROVINCE</th>							
								 <?php if($_SESSION['utilisateur']['role']=="ADMIN") {?> 
									<th>ACTIONS</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php while($CENTRE=$resultat1->fetch()){?>
								<tr>
									<td><?php echo $CENTRE['id'] ?></td>
									<td><?php echo $CENTRE['nom_centre'] ?></td>
									<td><?php echo $CENTRE['niveau'] ?></td>
									<td><?php echo $CENTRE['adresse_contacts'] ?></td>
									<td><?php echo $CENTRE['ville'] ?></td>
									<td><?php echo $CENTRE['province'] ?></td>
									
									<td>
										<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
											<!--  Action Editer une CENTRE -->
											<a href="editerCentre.php?id=<?php echo $CENTRE['id'] ?>">
												<span class="glyphicon glyphicon-pencil"></span>
											</a>
											
											&nbsp &nbsp
											<!--  Action Supprimer une CENTRE -->
											<a Onclick="return confirm('Etes vous sur de vouloir supprimer ce Centre/Institut?')" 
												href="supprimerCentre.php?id=<?php echo $CENTRE['id'] ?>">
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
									<a href="centres.php?page=<?php echo $i ?>
										&motCle=<?php echo $mc ?>
										&niveau=<?php echo $niveau ?>">
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