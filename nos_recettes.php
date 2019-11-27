<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Kakuteru</title>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
    <?php
    try
    {
        // On se connecte à MySQL
        $bdd = new PDO('mysql:host=localhost;dbname=kakuteru;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
    ?>
    <script>
        function suggestion(str) {
            const listSugg = document.getElementById("suggestion");
            if (str == "") {
                var opts = select.getElementsByTagName('option');
                for(var i = 0; i < opts.length; ){
                    listSugg.removeChild(opts[i]);
                }
                return;
            }
            else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    var optionListe='';
                    var liste = this.responseText.split("\n");
                    for (var i=0; i < liste.length;++i){
                        optionListe += "<option value=\""+liste[i]+"\" />\n"; // Storing options in variable
                    }
                    listSugg.innerHTML = optionListe;
                };
                xmlhttp.open("GET","getIng.php?ing="+str,true);
                xmlhttp.send();

            }
        }
    </script>


</head>
<body>
<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <h1><a href="./kakuteru.php">Kakuteru</a></h1>
        </div>
        <div id="menu">
            <ul>
                <li class="active"><a href="./kakuteru.php" accesskey="1" title="">Accueil</a></li>
                <li><a href="./nos_cocktails.php" accesskey="2" title="">Nos cocktails</a></li>
                <li><a href="#" accesskey="3" title="">Nos recettes</a></li>
                <li><a href="./mon_compte.php" accesskey="4" title="">Mon compte</a></li>
                <li><a href="./a_propos.php" accesskey="5" title="">A propos de nous</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="wrapper">
    <h2> FUTUR TRUC JASON DEROULANT (elle était pas ouf j'avoue)</h2>
    <form>
        <input type="text" list="suggestion" name="recherche" required="required" autocomplete="off" onkeyup="suggestion(this.value)"/>
        <datalist id="suggestion">
        </datalist>
    </form>
    <?php
    // On récupère tout le contenu de la table jeux_video
    $recettes = $bdd->query('SELECT * FROM recettes');

    // On affiche chaque entrée une à une
    while ($donnees = $recettes->fetch())
    {
        $titre = $donnees['nom'];
        $liaison = $bdd->prepare('SELECT nomIngredient FROM liaison WHERE nomRecette = :nomRecette');
        $liaison->bindParam(':nomRecette', $titre);
        $liaison->execute();
        ?>
        <p>
            <strong>Recette</strong> : <?php echo $donnees['nom']; ?><br />
            Ingredients : <?php while($liste = $liaison->fetch()){
                echo $liste['nomIngredient'];
                echo ", ";
            } ?><br />
        </p>
        <?php
    }

    $recettes->closeCursor(); // Termine le traitement de la requête
    $liaison->closeCursor(); // Termine le traitement de la requête

    ?>
</div>
</body>
</html>