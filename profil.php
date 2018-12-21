<?php
// Connexion à la base de données ↓↓↓
error_reporting(0);
require 'connexion.php';
$appliBD= new Connexion();
if(is_null($_POST["id"]) && is_null($_POST["nom"])){
    $_POST["id"]=1;
}
if(!is_null($_POST["nom"])){
    inscription();
}
else{
    $id=$_POST["id"];
}
$nomcomplet=$appliBD->getNom($id).", ".$appliBD->getPrenom($id);
?>
<!-- Début du HTML ↓↓↓ -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Définition de l'id afin d'afficher le profil de la bonne personne ↓↓↓ -->
    <title>Profil de:<?= $nomcomplet ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Lien avec la feuille CSS pour le style ↓↓↓ -->
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
<!-- Notre police d'écriture si jolie et si spéciale trouvée sur google ↓↓↓ -->
  <link href='https://fonts.googleapis.com/css?family=Barrio' rel='stylesheet'>
</head>

<body> 
<!-- Notre belle image de maison champignon qui nous dirige vers la page "Home" ↓↓↓  --> 
    <a href="home.php" id="home"><img class="imghome" src="image/home.png" alt="Maison champignon"></a>
    <div>
        <h1>
        PROFIL
        </h1>
    </div>

    <table>     
        <tr>
            <?php
// Reception de l'id pour afficher la photo ↓↓↓
                if(!is_null($_POST["id"])){
                    $lien= $appliBD->getImage($_POST["id"]);
                    echo '<td rowspan="2" id="topho"><div class="divInvisib"><img class="imgmerdique" src="'.$lien.'" alt="L" style="width:100%"></div></td>';
                }
                else{
                    echo '<td rowspan="2" id="topho"><div class="divInvisib"><img class="imgmerdique" src="'.$_POST["lien"].'" alt="L" style="width:100%"></div></td>';
                }
// Reception de l'ID personne pour afficher le Nom ↓↓↓
                if(!is_null($_POST["id"])){
                    $nom= $appliBD->getNom($_POST["id"]);
                    echo '<td class="nm"><div>'.$nom.'</div></td>';
                }
                else{
                    echo '<td class="nm"><div>'.$_POST["nom"].'</div></td>';
                }
// Reception de l'ID personne pour afficher la date de naissance et transformation de celle-ci ↓↓↓
                if(!is_null($_POST["id"])){
                    $date= $appliBD->getDate($_POST["id"]);
                    echo '<td rowspan="2" id="teda"><div>'.$appliBD->inverseDate($date).'</div></td>';
                }
                else{
                    echo '<td rowspan="2" id="teda"><div>'.$appliBD->inverseDate($_POST["naissance"]).'</div></td>';
                }
                
            ?>
        </tr>
        <tr>
            <?php
// Reception de l'ID pour afficher le Prénom ↓↓↓
                if(!is_null($_POST["id"])){
                    $prenom= $appliBD->getPrenom($_POST["id"]);
                    echo '<td class="nm"><div>'.$prenom.'</div></td>';
                }
                else{
                    echo '<td class="nm"><div>'.$_POST["prenom"].'</div></td>';
                }
            ?>
        </tr>

    </table>
        

        
    <div>
        <h2 id="stts">
        <?php
// Capture du statut afin de l'afficher vu que c'était important pour vous ↓↓↓
            if(!is_null($_POST["id"])){
                $etat= $appliBD->getStatut($_POST["id"]);
                echo '<td class="nm"><div>'.$etat.'</div></td>';
            }
            else{
                echo '<td class="nm"><div>'.$_POST["etat"].'</div></td>';
            }
        ?>
        </h2>
    </div>

    <div class="flxbx">
        <h2><div class="divInvisib">
        Musique</div>
        </h2>
        <div>
            <ul class="muse">
            <?php 
// Pareil qu'en haut pour la musique ↓↓↓
                if(!is_null($_POST["id"])){
                    $musique= $appliBD->getPersonneMusique($_POST["id"]);
                    foreach ($musique as $music){
                        echo '<li>'.$music["Type"].'</li>';
                    }
                }
                else{
                    foreach ($_POST["metal"] as $music){
                        echo '<li>'.$appliBD->getMusiquebyId($music).'</li>';
                    }
                }
            ?>
                
               
            </ul>
        </div>
    </div>

    <div class="flxbx">
        <h2><div class="divInvisib">
            Hobbies</div>
        </h2>
        <div>
            <ul class="muse">
            <?php 
// Pareil qu'en haut pour les hobbies ↓↓↓
                if(!is_null($_POST["id"])){
                    $hobbies= $appliBD->getPersonneHobby($_POST["id"]);
                    foreach ($hobbies as $hobby){
                        echo '<li>'.$hobby["Type"].'</li>';
                    }
                }
                else{
                    foreach ($_POST["jouer"] as $hobby){
                        echo '<li>'.$appliBD->getHobbyById($hobby).'</li>';
                    }
                }
            ?>
            </ul>
        </div>
    </div>

    <div>
        <table class="photo_profil">
            <tr>
                <?php
// Pareil qu'en haut pour les relations mais avec la boucle pour les afficher toutes ↓↓
                if(!is_null($_POST["id"])){
                    $relations=$appliBD->getRelationPersonne($_POST["id"]);
                    $count=1;
                    foreach($relations as $rel){
                        if(!is_null($rel)){
                            if(($count-1)%3==0){
                                echo'<tr>';
                            }
                            $id=$appliBD->searchId($rel["Nom"]);
                            $lien=$appliBD->getImage($id);
                            echo '
                                <form action="profil.php" method="post">
                                    <td class="tdprofil">
                                        <div class="divInvisib">
                                            <input type="hidden" name="id" value="'.$id.'">
                                            <input type="image"  class="imgmerdique" src="'.$lien.'" alt="'.$appliBD->getNom($id).' '.$appliBD->getPrenom($id).'">
                                        </div>
                                        <p class="np_profil">'.$rel["Nom"].', '.$rel["Prenom"].' :    '.$rel["Type"].'</p>
                                    </td>
                                </form>
                            ';
                            if($count%3==0){
                                echo'</tr>';
                            }
                        }
                        $count++;
                    }
                }
                else{
                    $count=1;
                    foreach($_POST["relations"] as $rel){
                        if($rel!=""){
                            if(($count-1)%3==0){
                                echo'<tr>';
                            }
                            $id=$appliBD->searchId($_POST["Nom"]);
                            $lien=$appliBD->getImage($count);
                            echo '<form action="profil.php" method="post">';
                            echo '<td class="tdhome">';
                            echo '<div class="divInvisib">';
                            echo '<input type="hidden" name="id" value="'.$id.'">';
                            echo '<input type="image"  class="imgmerdique" src="'.$lien.'" alt="'.$appliBD->getNom($count).' '.$appliBD->getPrenom($count).'">';
                            echo '</div>';
                            echo '<p class="np_home">'.$appliBD->getNom($count).', '.$appliBD->getPrenom($count).' :    '.$rel.'</p>';
                            echo '</td>';
                            echo '</form>';
                            if($count%3==0){
                                echo'</tr>';
                            }
                        }
                        $count++;
                    }
                }
                ?>
            </tr>
          
        </table>
    </div>
    <div>
        <a href="creer_compte.php">Créer un compte?</a>
    </div>

</body>
</html>
<?php
// Fonction inscription pour récupérer toutes les informations entrées dans "Créer Compte" ↓↓
function inscription(){
    $count=1;
    $appliBD=new Connexion;
    $appliBD->insertPersonne($_POST["nom"],$_POST["prenom"],$_POST["lien"],$_POST["naissance"],$_POST["etat"]);
    $newId=$appliBD->searchId($_POST["nom"]);
    $newId2=$appliBD->searchId($_POST["prenom"]);
    if($newId==$newId2){
        $id=$newId;
    }
    else{
        $id=$newId2;
    }
    
    if(!is_null($_POST["metal"])){
        $appliBD->insertPersonneMusique($id,$_POST["metal"]);
    }
    if(!is_null($_POST["jouer"])){
        $appliBD->insertPersonneHobbies($id,$_POST["jouer"]);
    }
    if(!is_null($_POST["relations"])){
        foreach($_POST["relations"] as $rel){
            if($rel!==""){
                $appliBD->insertPersonneRelation($id,$count,$rel);
            }
            $count++;
        }
        
    }
}
?>