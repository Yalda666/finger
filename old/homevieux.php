<?php
require('connexion.php');


echo <<<MON_HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    // <link href='https://fonts.googleapis.com/css?family=Barrio' rel='stylesheet'>
    <script src="main.js"></script>
</head>

<body>
    <div>
        <h1>Recherche de profils</h1>
        <input type=text id=recherche placeholder="Veuillez taper votre recherche de profils ici">
    </div>
    <table class="photo_home">
        <tr>
            <td>
                <div class="photo">
                    <a href="profil.html">
                        <h2>Topho</h2>
                    </a>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
            <td>
                <div class="photo">
                    <h2>Photo</h2>
                </div>
                <p class="np_home">Nom Prénom</p>
            </td>
        </tr>
    </table>
    <br>
    <div>
        <a href="creer_compte.php">Créer un compte?</a>
    </div>
</body>

</html>

MON_HTML;




if(!is_null($_POST)){
    inscription();
}

function inscription(){
    $appliBD=new Connexion;
    $appliBD->insertPersonne($_POST["nom"],$_POST["prenom"],$_POST["lien"],$_POST["naissance"],$_POST["etat"]);
    $newId=$appliBD->searchId($_POST["nom"]);
    if(!is_null($_POST["metal"])){
        $appliBD->insertPersonneMusique($newId,$_POST["metal"]);
    }
    if(!is_null($_POST["jouer"])){
        $appliBD->insertPersonneHobbies($newId,$_POST["jouer"]);
    }
}

?>