<?php
	require_once('session.php');
?>
<?php
	
	require_once('connexion.php');
	
	if(isset($_GET['motCle']))
		$mc=$_GET['motCle'];
	else
		$mc="";
	
	if(isset($_GET['id_centre']))
		$idce=$_GET['id_centre'];
	else
		$idce=0;
		
	if(isset($_GET['size']))
		$size=$_GET['size'];
	else
		$size=100;
		
	if(isset($_GET['page']))
		$page=$_GET['page'];
	else
		$page=1;
			
	$offset=($page-1)*$size;
	
	if($idce==0){// TOUTES LES centres
		$resultat = $con->query("SELECT CH.id,nom,prenom,nom_centre,grade,matricule,champs_activites,publications,photo
								FROM CHERCHEUR CH,CENTRE CE
								WHERE CH.id_centre=CE.id
								AND (nom like '%$mc%' OR prenom like '%$mc%')
								ORDER BY CH.id
								LIMIT $size
								OFFSET $offset");

		$resultat2 = $con->query("select count(*) as nbrCHERCHEUR 
								from CHERCHEUR 
								where nom like '%$mc%' OR prenom like '%$mc%'");
	}
	else{
		$resultat = $con->query("SELECT CH.id,nom,prenom,nom_centre,grade,matricule,champs_activites,publications,photo
								FROM CHERCHEUR CH,CENTRE CE
								WHERE CH.id_centre=CE.id
								AND (nom like '%$mc%' OR prenom like '%$mc%')
								And id_centre=$idce
								ORDER BY CH.id
								LIMIT $size
								OFFSET $offset");

		$resultat2 = $con->query("select count(*) as nbrCHERCHEUR 
								from CHERCHEUR 
								where (nom like '%$mc%' OR prenom like '%$mc%')
								And id_centre=$idce");
	}
	
	
	$nbr=$resultat2->fetch();
	
	$nbrPro=$nbr['nbrCHERCHEUR'];
	
	$reste=$nbrPro % $size; //l'operateur % (modulo) retourne le reste de la 
						// devision euclidienne de $nbrPro sur $size
	if($reste==0)
		$nbrPage=$nbrPro/$size;
	else
		$nbrPage=floor($nbrPro/$size)+1;// floor retourne la partie entière d'un nombre 
										// decimale
										
	$requetece="select * from CENTRE";
	$resultatce = $con->query($requetece);
										
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Gestion des CHERCHEUR</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	</head>
	<body>
		 <div id="wrapper">
			<?php include('entete.php');?>
			
			<div class="container">
				<div class="panel panel-success espace60">
					<div class="panel-heading">RECHERCHER DES CHERCHEUR</div>
					<div class="panel-body">
						<form method="get" action="chercheurs.php" class="form-inline">
						<div class="form-group">						
								<select name="id_centre" id="id_centre" class="form-control"
									onChange="this.form.submit();">
									<option value="0" >Tous les centres/Instituts</option>
									<?php while($CENTRE=$resultatce->fetch()){ ?>
										<option value="<?php echo $CENTRE['id']?>" 
											<?php echo $idce==$CENTRE['id']?"selected":"" ?>>
											<?php echo $CENTRE['nom_centre']?>
										</option>									
									<?php } ?>
								</select>
								
								<input type="text" name="motCle" 
										placeholder="Taper un mot clé"
										id="motCle" class="form-control" 
										value="<?php echo $mc; ?>"/>
								<input type="hidden" name="size"  value="<?php echo $size ?>">		
								<input type="hidden" name="page"  value="<?php echo $page ?>">
								<button type="submit" class="btn btn-success">
									<i class="glyphicon glyphicon-search"></i>
									Chercher...
								</button>
								&nbsp;&nbsp;&nbsp;
								<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
									<a class="btn btn-success" href="nouveauChercheur.php">Nouveau Chercheur</a>
								<?php } ?>	
							</div>
						</form>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
					
					LISTES DES CHERCHEUR (<?php echo $nbrPro ?> &nbsp CHERCHEUR) 
					
					</div>
					<div class="panel-body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>NOM & POST-NOM</th>
									<th>PRENOM</th>
									<th>CENTRE</th>
									<th>GRADE</th>
									<th>MATRICULE</th>
									<th>DOMAINES</th>
									<th>PUBLICATIONS</th>
									<th>AVATAR</th>
									 <?php if($_SESSION['utilisateur']['role']=="ADMIN") {?> 
										<th>ACTIONS</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php while($CHERCHEUR=$resultat->fetch()){?>
									<tr>
										<td><?php echo $CHERCHEUR['id'] ?></td>
										<td><?php echo $CHERCHEUR['nom'] ?></td>
										<td><?php echo $CHERCHEUR['prenom'] ?></td>
										<td><?php echo $CHERCHEUR['nom_centre'] ?></td>
										<td><?php echo $CHERCHEUR['grade'] ?></td>
										<td><?php echo $CHERCHEUR['matricule'] ?></td>
										<td><?php echo $CHERCHEUR['champs_activites'] ?></td>
										<td><?php echo $CHERCHEUR['publications'] ?></td>	
										<td>
											<img src="../images/<?php echo $CHERCHEUR['photo']?>" 
												class="img-thumbnail"  width="60" height="60" >
										</td>	
										<td>
											<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
												<!--  Action Editer un chercheur -->
												<a href="editerChercheur.php?id=<?php echo $CHERCHEUR['id'] ?>">
													<span class="glyphicon glyphicon-edit"></span>
												</a>
												
												&nbsp;
												<!--  Action Supprimer un chercheur -->
												<a Onclick="return confirm('Êtes vous sûr de vouloir supprimer ce chercheur?')" 
													href="supprimerChercheur.php?id=<?php echo $CHERCHEUR['id'] ?>">
													<span class="glyphicon glyphicon-trash"></span>
												</a>
											<?php } ?>

											<a class="btn btn-info btn-edit-delete"
												href="../fpdf/page_document.php?id=<?php echo $CHERCHEUR['id'] ?>">
												<span class="glyphicon glyphicon-print"></span>
											</a>

											<a class="btn btn-info btn-edit-delete"
												href="page_chercheur.php?id=<?php echo $CHERCHEUR['id'] ?>" > 
												<span class="glyphicon glyphicon-info-sign"></span>
											</a>
											
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<div>																						
								<ul class="nav nav-pills nav-right">
									<li>
										<form class="form-inline">
											<label>Nbre de chercheur/Page </label>
											<input type="hidden" name="id_centre" 
												value="<?php echo $idce ?>">
											<input type="hidden" name="motCle" 
												value="<?php echo $mc ?>">
											<input type="hidden" name="page" 
												value="<?php echo $page ?>">
											<select name="size" class="form-control"
													onchange="this.form.submit()">
												<option <?php if($size==100) echo "selected" ?>>100</option>
												<option <?php if($size==200) echo "selected" ?>>200</option>
												<option <?php if($size==250) echo "selected" ?>>250</option>
												<option <?php if($size==300) echo "selected" ?>>300</option>
												<option <?php if($size==500) echo "selected" ?>>500</option>
											</select>
										</form>
									</li>
									<?php for($i=1;$i<=$nbrPage;$i++){ ?>
										<li class="<?php if($i==$page) echo 'active' ?>">
											<a href="chercheurs.php?page=<?php echo $i ?>
											&motCle=<?php echo $mc ?>
											&id_centre=<?php echo $idce ?>
											&size=<?php echo $size ?>">
												<?php echo $i ?>
											</a>
										</li>
									<?php } ?>	
								</ul>
							
						</div>
						
					</div>				
				</div>	
				
			</div>
		</div>
	</body>
</html>