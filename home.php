<?php
// Inclusion du fichier connexion et suppression de l'affichage des erreurs pour enlever les notifications d'index manquants dans le post
require('connexion.php');
error_reporting(0);

// Début du html header et body, barre de recherche créée et renvoie la chaîne de caractères entrée en POST à la même page pour afficher les bons résultats
echo <<<MON_HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link href='https://fonts.googleapis.com/css?family=Barrio' rel='stylesheet'>
    <script src="main.js"></script>
</head>

<body>
    <div>
        <h1>Recherche de profils</h1>
        <form action="home.php" method="post">
        <input type=text id=recherche name=recherche placeholder="Veuillez taper votre recherche de profils ici" autofocus>
        <br>
        <input id="submit_chrch" type="submit" value="Rechercher" style=font-size:150%;border-radius:45%;height:3em;>
        </form>
    </div>
   
    
</body>

</html>

MON_HTML;


// Si le $POST est nul ou si on a recherché aucune chaîne de caractères on popule la page grâce à la fonction population
if(is_null($_POST) || $_POST["recherche"]==""){
    population();
}
// Si le $POST n'est pas nul ou si on a recherché une chaîne de caractères on popule la page grâce à la fonction search_personne qui renverra le bon tableau de personnes recherchées
if(!is_null($_POST["recherche"]) && $_POST["recherche"]!==""){
    $appliBD=new Connexion;
    $ids=$appliBD->search_personne($_POST["recherche"]);
// Début tableau
    echo '
        <table class="photo_home">
        
    ';
// Compteur j pour formater le tableau de sorte à ce qu'il n'y ait que 3 personnes affichées par ligne
    $j=1;
// Début du parcours du tableau d'ids retourné par la fonction search_personne
    foreach($ids as $i){
// récupération de l'url de la photo, du nom et du prénom
        $lien=$i["URL_Photo"];
        $nom=$i["Nom"];
        $prenom=$i["Prenom"];
// formatage tableau tous les 3 affichages
        if(($j-1)%3==0){
            echo'<tr>';
        }
// Affichage de la photo, du nom et du prénom de la personne dans une div invisible avec un input invisible afin de pouvoir cliquer sur l'image pour afficher le profil
        echo '
                    <form action="profil.php" method="post">
                    <td class="tdhome">
                        <div class="divInvisib">
                            <input type="hidden" name="id" value="'.$i["Id"].'"></input>
                            <input type="image" src='.$lien.' class="imgmerdique"></input>
                        </div>
                        <p class="np_home" name="id" value="'.$i["Id"].'">'.$nom.' '.$prenom.'</p>
                    </td>
                    </form>
        ';
        if($i%3==0){
            echo'</tr>';
        }
        $j++;
    }
// Fin de la table et affichage du bouton pour créer un compte
    echo '
    </table>
    <div>
        <a href="creer_compte.php">Créer un compte?</a>
    </div>
    ';
}

// Fonction population qui peuple l'affichage de la page avec les photos, les noms et les prénoms des personnes contenues dans la base de données
function population(){
    $appliBD=new Connexion;
    $newId=$appliBD->getCompteId();
    echo '
        <table class="photo_home">
    ';
    for($i=1;$i<=$newId;$i++){
        $lien=$appliBD->getImage($i);
        $nom=$appliBD->getNom($i);
        $prenom=$appliBD->getPrenom($i);
        if(($i-1)%3==0){
            echo'<tr>';
        }
        echo '
            <form action="profil.php" method="post">
                <td class="tdhome">
                    <div class="divInvisib">
                        <input type="hidden" name="id" value="'.$i.'">
                        <input type="image" src='.$lien.' class="imgmerdique">
                    </div>
                    <p class="np_home" name="id" value="'.$i.'">'.$nom.' '.$prenom.'</p>
                </td>
            </form>
        ';
        if($i%3==0){
            echo'</tr>';
        }
    }
    echo'
    </table>
    <div>
        <a href="creer_compte.php">Créer un compte?</a>
    </div>
    ';  
}

?>
