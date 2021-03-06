<?php
// Démarrage ou restauration de la session
session_start();
// Réinitialisation du tableau de session
// On le vide intégralement
$_SESSION = array();
// Destruction de la session
session_destroy();
// Destruction du tableau de session
unset($_SESSION);
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
    <div id="header" class="container">
        <div id="logo">
            <h1><a href="../">Kakuteru</a></h1>
        </div>

        <!--Bandeau de navigation-->
        <div id="menu">
            <ul>
                <li class="active"><a href="../kakuteru" accesskey="1" title="">Accueil</a></li>
                <li><a href="../Cocktails/" accesskey="2" title="">Nos cocktails</a></li>
                <li><a href="../Recettes/" accesskey="3" title="">Nos recettes</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="wrapper">
    <div id="staff" class="container">
        <div class="title">
            <h2>Déconnexion</h2>
            <p>Vous êtes bien déconnecté. Pour revenir à la page d'accueil <a href="../">cliquez ici</a></p> </div>
    </div>
</div>

</body>
</html>
