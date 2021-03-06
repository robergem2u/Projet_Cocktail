<?php
include("../ConnexionBD/index.php");
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
    <?php

    function str_replace_cocktail($str)
    {
        $newStr = $str;
        $newStr = preg_replace('#Ç#', 'C', $newStr);
        $newStr = preg_replace('#ç#', 'c', $newStr);
        $newStr = preg_replace('#è|é|ê|ë#', 'e', $newStr);
        $newStr = preg_replace('#È|É|Ê|Ë#', 'E', $newStr);
        $newStr = preg_replace('#à|á|â|ã|ä|å#', 'a', $newStr);
        $newStr = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $newStr);
        $newStr = preg_replace('#ì|í|î|ï#', 'i', $newStr);
        $newStr = preg_replace('#Ì|Í|Î|Ï#', 'I', $newStr);
        $newStr = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $newStr);
        $newStr = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $newStr);
        $newStr = preg_replace('#ù|ú|û|ü#', 'u', $newStr);
        $newStr = preg_replace('#Ù|Ú|Û|Ü#', 'U', $newStr);
        $newStr = preg_replace('#ý|ÿ#', 'y', $newStr);
        $newStr = preg_replace('#Ý#', 'Y', $newStr);
        $newStr = preg_replace('#ń|ǹ|ň|ñ#', 'n', $newStr);
        $newStr = preg_replace('#Ñ|Ń|Ǹ|Ň|ň#', 'N', $newStr);
        $newStr = str_replace(' ', '_', $newStr);
        $newStr = str_replace("'", '', $newStr);

        return ($newStr);
    }
    ?>

    <script>
        var listeAjout = new Array();
        var listeSupp = new Array();

        //Fonction qui ajoute à la liste déroulante les options de complétion
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
                    // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else {
                    // code pour les navigateurs IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    var optionListe='';
                    var liste = this.responseText.split("\n");
                    for (var i=0; i < liste.length;++i){
                        optionListe += "<option value=\""+liste[i]+"\" />\n"; // Stockage des options dans une variable
                    }
                    listSugg.innerHTML = optionListe;
                };
                xmlhttp.open("GET","getIng.php?ing="+str,true);
                xmlhttp.send();

            }
        }

        //Fonction qui retire un ingredient de la recherche d'ajout ainsi que son bouton
        function deleteIngAjout(str){
            listeAjout.splice(listeAjout.indexOf(str), 1);
            afficheRecette("");
            var btn = document.getElementById(str);
            btn.remove();
        }

        //Fonction qui retire un ingredient de la recherche de suppression ainsi que son bouton
        function deleteIngSupp(str){
            listeSupp.splice(listeSupp.indexOf(str), 1);
            afficheRecette("");
            var btn = document.getElementById(str);
            btn.remove();
        }

        //Focntion qui ajoute un ingrédient à la recherche d'ajout et crée son bouton
        function ajoutIng(str) {
            if(listeAjout.indexOf(str) == -1) {
                /*Ajout de l'ingrédient à la liste des ajouts*/
                listeAjout.push(str);

                /*Création du bouton*/
                var form = document.getElementById('boutonsAjouts');
                var btn = document.createElement("BUTTON");
                btn.setAttribute("id", str);

                btn.setAttribute("class", "btnAjout");
                btn.setAttribute("onclick", "deleteIngAjout(this.id)");
                btn.innerHTML = "<span>"+str+"</span>";
                form.insertBefore(btn, null);
            }
        }

        //Focntion qui ajoute un ingrédient à la recherche de suppression et crée son bouton
        function suppressionIng(str) {
            /*Ajout de l'ingrédient à la liste des suppressions*/
            if(listeSupp.indexOf(str) == -1) {
                listeSupp.push(str);

                /*Création du bouton*/
                var form = document.getElementById('boutonsSuppressions');
                var btn = document.createElement("BUTTON");

                btn.setAttribute("id", str);
                btn.setAttribute("class", "btnSupp");
                btn.setAttribute("onclick", "deleteIngSupp(this.id)");
                btn.innerHTML = "<span>"+str+"</span>";

                form.insertBefore(btn, null);
            }
        }

        //Affiche les recettes en fonction des différentes listes de recherche
        function afficheRecette(cond) {
            if (cond == 'ajout') {
                ajoutIng(document.getElementById('ingVoulu').value);
            } else if (cond == 'supp') {
                suppressionIng(document.getElementById('ingNonVoulu').value);
            }

            var str = "";
            var div = document.getElementById('listeCocktails');

            /*On supprime tous les cocktails qui sont déjà affichés*/
            div.innerHTML = "";

            var cpt = 0;
            var strAjout = "";
            var strSupp = "";

            /*On ajoute tous les ingrédients que l'on veut dans la requête*/
            cpt = 0;
            listeAjout.forEach(element => {
                strAjout += "nomRecette IN (SELECT nomRecette FROM Liaison WHERE nomIngredient = \"" + element + "\")";
                if (cpt < listeAjout.length - 1) {
                    strAjout += " AND ";
                }
                cpt += 1;
            });

            /*On ajoute tous les ingrédients que l'on ne veut pas dans la requête*/
            cpt = 0;
            listeSupp.forEach(element => {
                //str+="["+element;
                strSupp += "nomRecette NOT IN (SELECT nomRecette FROM Liaison WHERE nomIngredient = \"" + element + "\")";
                if (cpt < listeSupp.length - 1) {
                    strSupp += " AND ";
                }
                cpt += 1;
            });

            if (window.XMLHttpRequest) {
                // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code pour les navigateurs IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            var element = document.createElement("p");

            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4) {
                    var liste = this.responseText.split("\n");
                    element.innerHTML = innerHTMLRecette(liste);
                    div.insertBefore(element, null);
                }
            };

            if (strAjout != "") {
                str += "(" + strAjout + ")";
                if (strSupp != "") {
                    str += " AND (" + strSupp + ")";
                }
            } else {
                if (strSupp != "") {
                    str += strSupp;
                }
            }
            xmlhttp.open("GET", "getRecette.php?ing=" + str, false);
            xmlhttp.send();
        }

        //Retourne le corps HTML du paragraphe des recettes
        function innerHTMLRecette(liste){
            var listeRecettes = String(liste).split("_");
            var strP = "<br><br>";
            var innerListe;
            for(var j=0; j<listeRecettes.length-1; j++) {
                innerListe = listeRecettes[j].split(",");
                strP += "<strong>Recette</strong> : " + innerListe[0] + "<br>Ingredients : ";
                for (var i = 1; i < innerListe.length; ++i) {
                    strP += innerListe[i];
                    if (i < innerListe.length - 2) {
                        strP += ", ";
                    }
                }
                strP += "<br>";
            }
            return strP;
        }
    </script>


</head>
<body>
<div id="header-wrapper">
  <?php
        //On affiche le bouton déconnexion si l'utilisateur est connecté
		if (isset($_SESSION['login'])){
	?>
		<button onclick = "location.href='../Deconnexion/'" class="button" style=vertical-align:middle>Déconnexion</button>
	<?php
		}
        //On affiche le bouton connexion si l'utilisateur n'est pas connecté
		else{
	?>
		<button onclick="window.location.href = '../ConnexionSite/';" class="button" style=vertical-align:middle>Connexion</button>
	<?php } ?>


    <div id="header" class="container">
        <div id="logo">
            <h1><a href="../index.php">Kakuteru</a></h1>
        </div>

        <!--Bandeau de navigation-->
        <div id="menu">
            <ul>
                <li class="active"><a href="../" accesskey="1" title="">Accueil</a></li>
                <li><a href="../Cocktails/" accesskey="2" title="">Nos cocktails</a></li>
                <li><a href="#" accesskey="3" title="">Nos recettes</a></li>
                <!--On affiche l'onglet mon compte si l'utilisateur est connecté-->
        				<?php if (isset($_SESSION['login'])){ ?>
        				<li><a href="../Compte/" accesskey="4" title="">Mon compte</a></li>
        				<?php } ?>
            </ul>
        </div>
    </div>
</div>


<div id="wrapper">
  <div id="page" class="container">
    <h2> Recherche des cocktails en fonction de vos envies</h2>
    <div class="boxC">
      <div id="listeCocktails"></div>
      <br>
    </div>
    <div class = "boxA">
      <div class="formulaires">
        <br>
        <legend>Ajoutez les ingrédients que vous souhaitez dans votre cocktail</legend>
        <input id="ingVoulu" type="search" name="ingVoulu" type="text" list="suggestion" required="required" autocomplete="off" onkeyup="suggestion(this.value)"/>
        <datalist id="suggestion">
        </datalist>
        <button id="validerAjout" name="Valider" onclick="afficheRecette('ajout')">Valider</button>
        <div id="boutonsAjouts"></div>
      </div>
    </div>
    <div class="boxB">
      <div class="formulaires">
        <br>
        <legend>Ajoutez les ingrédients que vous ne souhaitez pas dans votre cocktail</legend>
        <input id="ingNonVoulu" type="search" name="ingNonVoulu" type="text" list="suggestion" required="required" autocomplete="off" onkeyup="suggestion(this.value)"/>
        <datalist id="suggestion">
        </datalist>
        <button id="validerAjout" name="Valider" onclick="afficheRecette('supp')">Valider</button>
        <div id="boutonsSuppressions"></div>
      </div>
    </div>
    </div>
  </div>
</div>
</body>
</html>
