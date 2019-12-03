<?php
include("../ConnexionBD/connexion.php");
session_start();
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>Kakuteru</title>
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="../default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../fonts.css" rel="stylesheet" type="text/css" media="all" />


</head>
<body>

<div id="header-wrapper">
	<?php
	if (isset($_SESSION['login'])){
	?>
		<button onclick = "location.href='../Deconnexion/deconnexion.php'" class="button" style=vertical-align:middle>Déconnexion</button>
	<?php
	}else{
	?>
		<button onclick="window.location.href = '../ConnexionSite/connexion.php';" class="button" style=vertical-align:middle>Connexion</button>
	<?php } ?>
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="../kakuteru.php">Kakuteru</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="active"><a href="../kakuteru.php" accesskey="1" title="">Accueil</a></li>
				<li><a href="../Cocktails/nos_cocktails.php" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="../Recettes/nos_recettes.php" accesskey="3" title="">Nos recettes</a></li>
				<?php if (isset($_SESSION['login'])){ ?>
				<li><a href="#" accesskey="4" title="">Mon compte</a></li>
				<?php } ?>
				<li><a href="../A_Propos/a_propos.php" accesskey="5" title="">A propos de nous</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
	<h2>
	<?php
	// TODO
	// récuperer le nom dans la bdd et comparer si égale "null" alors
	echo "Espace personnel du membre : ".$_SESSION['login'];
	// sinon afficher le nom
	?>
	</h2>
	<br><br>
	<div id="page" class="container">
		<div class="boxA">
			<form class="" action="#" method="post">
				<p>Email : <?php echo $_SESSION['login']; ?> </p>
				<?php if (isset($_POST["submit"])){?>
				<input name="email" type="email" placeholder="Nouvel email" required="" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+"><br>
				<?php } ?>
				<br>
				<p><input name = "submit" type="submit" value="Modifier Informations"></p>
			</form>
		</div>
	</div>
</div>
</body>
</html>
