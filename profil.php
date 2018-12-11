<?php

require 'connexion.php';


echo <<<MON_HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profil de: NOM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Barrio' rel='stylesheet'>
</head>
<body> 
    <a href="home.html" id="home"><img class="imghome" src="image/home.png" alt="Maison champignon"></a>
    <div>

        <h1>
        PROFIL
        </h1>
    </div>

<table>     
<tr>
    <td rowspan="2" id="topho"><div class="divInvisib"><img class="imgmerdique" src="image/LDn.jpg" alt="L" style="width:100%"></div></td>
    <td class="nm"><div>INCONNU</div></td>
    <td rowspan="2" id="teda"><div>DATE INCONNUE</div></td>
</tr>
<tr>
    
    <td class="nm"><div>L</div></td>
    
</tr>

</table>
        

        
    <div>
        <h2 id="stts">
        AUTRE
        </h2>
    </div>

    <div class="flxbx">
        <h2><div class="divInvisib">
        Musique</div>
        </h2>
        <div>
            <ul class="muse">
                <li>J-POP</li>
                <li>Japan Metal</li>
                <li>Rock</li>
            </ul>
        </div>
    </div>

    <div class="flxbx">
        <h2><div class="divInvisib">
            HOBBIES</div>
        </h2>
        <div>
            <ul class="muse">
                <li>Aquaponey</li>
                <li>Chasse aux criminels</li>
                <li>Manger</li>
            </ul>
        </div>
    </div>

    <div>
        <table id="sonic">
            <tr>
                <td><img class="imgmerdique" src="image/raito_yagami.jpg" alt="Raito Yagami"></td>
                <td>Yagami, Raito</td>
            </tr>
            <tr>
                <td><img class="imgmerdique" src="image/misamisa.jpg" alt="Misa Misa"></td>
                <td>Misa, Misa</td>
            </tr>
            <tr>
                <td>PHOTO</td>
                <td>NOM, PRENOM</td>
            </tr>
        </table>
    </div>
    <div>
        <button type="button">Créer un compte?</button> 
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