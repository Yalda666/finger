<!DOCTYPE html>
<html lang="en">

<!-- Header -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Créer un compte</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link href='https://fonts.googleapis.com/css?family=Barrio' rel='stylesheet'>
    <script src="main.js"></script>
</head>

<!-- Body -->
<body>
<!-- Lien champignon sur Home -->
    <a href="home.php" id="home"><img class="imghome" src="image/home.png" alt="Maison champignon"></a>
<!-- Titre -->
    <div>
        <h1>Créer un compte</h1> 
        <h3>(seulement si vous en avez vraiment envie.... )</h3>
    </div>
<!-- Début formulaire -->
    <form action="profil.php" method="post">
<!-- URL Photo -->
    <div>
        <h2>Photo</h2>
        <h3>(pour voir votre sale tronche...)</h3>
        <input type=url id=url name=lien placeholder="Veuillez taper l'URL de votre photo ici" style=width:35%; autofocus required>
    </div>
<!-- Début de contact -->
    <div>
        <h2>Contact</h2>
        <h3>(pour savoir comment</h3>
        <h3>on doit vous appeler...)</h3>
<!-- Nom -->
        <table class=input_name>
            <tr>
                <td class="input_td">
                    <h3>Nom</h3>
                </td>
                <td class="input_td"><input class="inputtext" type=text id=nom name=nom placeholder="Veuillez taper votre nom ici" required></td>
            </tr>
<!-- Prénom -->
            <tr>
                <td class="input_td">
                    <h3>Prénom</h3>
                </td>
                <td class="input_td"><input class="inputtext" type=text id=prenom name=prenom placeholder="Veuillez taper votre prénom ici" required></td>
            </tr>
<!-- Date de naissance -->
            <tr>
                <td class="input_td">
                    <h3>Date de naissance</h3>
                </td>
                <td class="input_td"><input class="inputtext" type=date id=naissance name=naissance placeholder="Veuillez taper votre date de naissance ici" required></td>
            </tr>
<!-- Statut d'état civil -->
            <tr>
                <td class="input_td">
                    <h3>Statut</h3>
                </td>
                <td class="input_td"><input class="inputtext" type=text id=statut name=etat placeholder="Veuillez taper votre statut d'état civil ici... ou pas" required></td>
            </tr>
        </table>
    </div>
<!-- Début des goûts -->
    <div>
        <h2>Goûts et couleurs</h2>
        <h3>(car on a pas tous les mêmes, y paraît...)</h3>
<!-- Musique -->
        <h3>Musique (pour ceux qui aiment la musique...)</h3>
        <?php
            require('connexion.php');
            $appliBD=new Connexion;
            $musiques=$appliBD->selectAllMusics();
            for($i=1;$i<count($musiques);$i++){
                echo '<div class="gout"><input type="checkbox" class=musique id="style'.$i.'" name="metal[]" value='.$i.'><label for="style'.$i.'">'.$musiques[($i-1)]["Type"].'</label></div>';
            }
        ?>
        <br>
<!-- Hobbies -->
        <h3>Hobbies (à ne pas confondre avec ceux aux pieds poilus...)</h3>
        <?php
            $hobbies=$appliBD->selectAllHobbies();
            for($i=1;$i<count($hobbies);$i++){
                echo '<div class="gout"><input type="checkbox" class=hobbies id="hobby'.$i.'" name="jouer[]" value='.$i.'><label for="hobby'.$i.'">'.$hobbies[($i-1)]["Type"].'</label></div>';
            }
        ?>
        <br>
    </div>
<!-- Début des relations sociales -->
    <div>
        <h2>Relations sociales</h2>
        <h3>(pour ceux qui en ont de réelles...)</h3>
    

<!-- Début php pour populer la liste des personnes avec qui se connecter -->
<?php
error_reporting(0);
population();
function population(){
    $appliBD=new Connexion;  
    $newId=$appliBD->getCompteId();
    for($i=1;$i<=$newId;$i++){
        $nom=$appliBD->getNom($i);
        $prenom=$appliBD->getPrenom($i);
        echo '
            <label for="id'.$i.'">'.$nom.' '.$prenom.'</label>    
                <input type=text name=relations[] class=id'.$i.' placeholder="Veuillez taper le type de relation ici">
            <br>
        ';
    } 
}

// Bouton submit qui renvoie les informations du formulaire vers la page profil
echo '
        <br>
    </div>
    <br>
    <br>
        <input id="submit_creer" type="submit" value="Créer le compte!!!!" style=font-size:150%;border-radius:45%;height:3em;>
    </form>
</body>

</html>
';
// Fin du formulaire et de la page creer_compte
?>