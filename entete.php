<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
				<a  class="navbar-brand" href="../accueil-csn/index.html">
					<span><img src="../images/csn-menu.png" class="logo">
					ACHECCIR-CSN</span>	
				</a>
		</div>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<ul class="nav navbar-nav">
		
			<li><a href="chercheurs.php">LES CHERCHEUR</a></li>
			<li><a href="membres.php">LES MEMBRES CSN</a></li>
			<li><a href="centres.php">LES CENTRE/INSTITUTS</a></li>
			<?php if($_SESSION['utilisateur']['role']=="ADMIN") {?>
				<li><a href="utilisateurs.php">LES USERS</a></li>
			<?php } ?>
			
		</ul>
		
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="editerUtilisateur.php?id=<?php echo $_SESSION['utilisateur']['id'];?>">
					<span class="glyphicon glyphicon-user"></span> 
					<?php echo $_SESSION['utilisateur']['login'];?>
				</a>
			</li>
			<li>
				<a href="seDeconnecter.php">
					<span class="glyphicon glyphicon-log-out"></span>
					Se Deconnecter
				</a>
			</li>
		</ul>
	</div>
</nav>