<?php
// Début de la classe Connexion
    class Connexion {
// Déclaration de la variable privée connexion qui fait la relation avec la base de données
        private $connexion;

// Constructeur de la classe qui initialise la connexion avec la base de données avec les paramètres interne à notre serveur phpmyadmin
        public function __construct() {
            try{
            
                $PARAM_hote='localhost';

                $PARAM_port='3306';

                $PARAM_nom_bd='MiniFacebook';

                $PARAM_utilisateur='phpmyadmin';

                $PARAM_mot_passe='digital2018';
                
                $this->connexion = new PDO(
                    'mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd,
                    $PARAM_utilisateur,
                    $PARAM_mot_passe
                );
                $this->connexion-> setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
            }
        }

// Fonction inverseDate qui formate la date de naissance sous un format plus intelligible et digérable pour nous Européens
        function inverseDate($naissance){
            $mot=str_split($naissance);
            $res=$mot[8].$mot[9];
            switch($mot[5].$mot[6]){
                case "01":
                    $res=$res." Janvier ";
                    break;
                case "02":
                    $res=$res." Février ";
                    break;
                case "03":
                    $res=$res." Mars ";
                    break;
                case "04":
                    $res=$res." Avril ";
                    break;
                case "05":
                    $res=$res." Mai ";
                    break;
                case "06":
                    $res=$res." Juin ";
                    break;
                case "07":
                    $res=$res." Juillet ";
                    break;
                case "08":
                    $res=$res." Août ";
                    break;
                case "09":
                    $res=$res." Septembre ";
                    break;
                case "10":
                    $res=$res." Octobre ";
                    break;
                case "11":
                    $res=$res." Novembre ";
                    break;
                case "12":
                    $res=$res." Décembre ";
                    break;
            }
            $res=$res.$mot[0].$mot[1].$mot[2].$mot[3];
            return $res;
        }

// Fonction insertHobby qui insère un hobby dans la base de données
        function insertHobby($hobby){
            try{
                $requete_prepare=$this->connexion->prepare(
                    "INSERT INTO Hobby (Type) values (:hobby)"
                );
                $requete_prepare->execute(
                    array( 'hobby' => $hobby)
                );
                echo "Inséré! <br />";
                return true;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                echo "Pas inséré! <br />";
                return false;
            }
        }

// Fonction insertMusique qui insère un style de musique dans la base de données
        function insertMusique($music){
            try{
                $requete_prepare=$this->connexion->prepare(
                    "INSERT INTO Musique (Type) values (:music)"
                );
                $requete_prepare->execute(
                    array( 'music' => $music)
                );
                echo "Inséré! <br />";
                return true;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                echo "Pas inséré! <br />";
                return false;
            }
        }

// Fonction insertPersonne qui insère une personne dans la base de données
        function insertPersonne($nom,$prenom,$url,$date,$statut){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'INSERT INTO Personne(Nom,Prenom,URL_Photo,Date_Naissance,Statut_Couple) values (:nom,:prenom,:lien,:naissance,:statut)'
                );
                $requete_prepare->execute(
                    array( 'nom' => $nom,'prenom' => $prenom,'lien' => $url,'naissance' => $date,'statut' => $statut)
                );
                echo "Inséré! <br />";
                return true;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                echo "Pas inséré! <br />";
                return false;
            }
        }

// Fonction selectAllHobbies qui sélectionne la liste des hobbies dans la base de données
        function selectAllHobbies(){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Type FROM Hobby'
                );
                $requete_prepare->execute();
                $resultat=$requete_prepare->fetchAll(PDO::FETCH_ASSOC);
                return $resultat;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction selectAllMusics qui sélectionne la liste des types de musique dans la base de données
        function selectAllMusics(){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Type FROM Musique'
                );
                $requete_prepare->execute();
                $resultat=$requete_prepare->fetchAll(PDO::FETCH_ASSOC);
                return $resultat;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction selectPersonneById qui sélectionne la personne dans la base de données qui a l'identifiant passée en paramètre et retourne tous ses attributs
        function selectPersonneById($id){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT * FROM Personne WHERE Id = :id'
                );
                $requete_prepare->execute(array("id" => $id));
                $resultat=$requete_prepare->fetch(PDO::FETCH_OBJ);
                return $resultat;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction searchId qui sélectionne l'identifiant dans la base de données qu'a la personne qui a le nom ou le prénom qui contient les lettres passées en paramètres
        function searchId($Nom) { 
            $query = "SELECT Id FROM Personne WHERE Prenom like :Nom or Nom like :Nom";
            $stmt = $this->connexion->prepare($query); 
            $result = $stmt->execute(array("Nom"=> "%".$Nom."%")); 
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $row[0]["Id"];
        } 

// Fonction search_personne qui sélectionne toutes les données dans la base de données qu'a la personne qui a le nom ou le prénom qui contient les lettres passées en paramètres
        function search_personne($Nom) { 
            $query = "SELECT * FROM Personne WHERE Prenom like :Nom or Nom like :Nom";
            $stmt = $this->connexion->prepare($query); 
            //$stmt->bindValue(':Nom','%'.$Nom.'%'); 
            $result = $stmt->execute(array("Nom"=> "%".$Nom."%")); 
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            //var_dump($row); //var_dump($stmt->errorInfo()); echo "Matches pour ".$Nom." et ".$prenom." : ".$stmt->rowCount()."</br>"; foreach ($row as $key => $value) { # code... echo $value["Prenom"]."<br>"; 
            return $row;
        } 

// Fonction getPersonneHobby qui sélectionne les hobbies associés à une personne dont l'identifiant est passé en paramètre
        function getPersonneHobby($personneId){
            try{
                $requete_prepare=$this->connexion->prepare(
                    "SELECT Type FROM RelationHobby
                    INNER JOIN Hobby ON Hobby_Id = Id
                    WHERE Personne_Id = :id"
                );
                $requete_prepare->execute(array("id" => $personneId));
                $hobbies=$requete_prepare->fetchAll(PDO::FETCH_ASSOC);
                return $hobbies;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }

        }

// Fonction getPersonneMusique qui sélectionne les types de musique associés à une personne dont l'identifiant est passé en paramètre
        function getPersonneMusique($personneId){
            try{
                $requete_prepare=$this->connexion->prepare(
                    "SELECT Type FROM RelationMusique
                    INNER JOIN Musique ON Musique_Id = Id
                    WHERE Personne_Id = :id"
                );
                $requete_prepare->execute(array("id" => $personneId));
                $musics=$requete_prepare->fetchAll(PDO::FETCH_ASSOC);
                return $musics;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }

        }

// Fonction getRelationPersonne qui sélectionne les noms, prénoms et type de relation des personnes associées à une personne dont l'identifiant est passé en paramètre
        function getRelationPersonne($personneId){
            try{
                $requete_prepare=$this->connexion->prepare(
                    "SELECT P2.Nom, P2.Prenom, RP.Type FROM Personne P2, RelationPersonne RP
                    INNER JOIN Personne P1 ON RP.Personne_Id = P1.Id
                    WHERE P1.Id = :id AND Relation_Id=P2.Id"
                );
                $requete_prepare->execute(array("id" => $personneId));
                $relations=$requete_prepare->fetchAll(PDO::FETCH_ASSOC);
                return $relations;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }

        }

// Fonction getHobbyById qui sélectionne le hobby associé à l'identifiant passé en paramètre
        function getHobbyById($id){
            try{
                $hobby_Id=$id;
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Type FROM Hobby
                    WHERE Id=:hobby'
                );
                $requete_prepare->execute(array("hobby" => $hobby_Id));
                $hid=$requete_prepare->fetch(PDO::FETCH_ASSOC);
                $hobby_Id=trim($hid["Type"]);
                return $hobby_Id;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction getMusiqueById qui sélectionne le type de musique associé à l'identifiant passé en paramètre
        function getMusiquebyId($id){
            try{
                $musique_Id=0;
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Type FROM Musique
                    WHERE Id=:musique'
                );
                $requete_prepare->execute(array("musique" => $id));
                $mid=$requete_prepare->fetch(PDO::FETCH_ASSOC);
                $musique_Id=trim($mid["Type"]);
                return $musique_Id;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction getImage qui sélectionne l'url de l'image associée à l'identifiant passé en paramètre
        function getImage($id){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT URL_Photo FROM Personne
                    WHERE Id=:id'
                );
                $requete_prepare->execute(array("id" => $id));
                $iid=$requete_prepare->fetch(PDO::FETCH_ASSOC);
                $image_Id=trim($iid["URL_Photo"]);
                return $image_Id;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction getNom qui sélectionne le nom de la personne associée à l'identifiant passé en paramètre
        function getNom($id){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Nom FROM Personne
                    WHERE Id=:id'
                );
                $requete_prepare->execute(array("id" => $id));
                $nid=$requete_prepare->fetch(PDO::FETCH_ASSOC);
                $nom_Id=trim($nid["Nom"]);
                return $nom_Id;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction getPrenom qui sélectionne le prénom de la personne associée à l'identifiant passé en paramètre
        function getPrenom($id){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Prenom FROM Personne
                    WHERE Id=:id'
                );
                $requete_prepare->execute(array("id" => $id));
                $pid=$requete_prepare->fetch(PDO::FETCH_ASSOC);
                $prenom_Id=trim($pid["Prenom"]);
                return $prenom_Id;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction getDate qui sélectionne la date de naissance de la personne associée à l'identifiant passé en paramètre
        function getDate($id){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Date_Naissance FROM Personne
                    WHERE Id=:id'
                );
                $requete_prepare->execute(array("id" => $id));
                $did=$requete_prepare->fetch(PDO::FETCH_ASSOC);
                $date=trim($did["Date_Naissance"]);
                return $date;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction getStatut qui sélectionne le statut d'état civil de la personne associée à l'identifiant passé en paramètre
        function getStatut($id){
            try{
                $requete_prepare=$this->connexion->prepare(
                    'SELECT Statut_Couple FROM Personne
                    WHERE Id=:id'
                );
                $requete_prepare->execute(array("id" => $id));
                $nid=$requete_prepare->fetch(PDO::FETCH_ASSOC);
                $nom_Id=trim($nid["Statut_Couple"]);
                return $nom_Id;
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction getCompteId qui retourne le nombre d'identifiants total dans la base de données
        function getCompteId(){
            try{
                $requete_prepare1=$this->connexion->prepare(
                    'SELECT COUNT(Id) FROM Personne'
                );
                $requete_prepare1->execute();
                $cid=$requete_prepare1->fetch(PDO::FETCH_ASSOC);
                return $cid["COUNT(Id)"];
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }
        }

// Fonction insertPersonneHobbies qui fait la relation entre une personne et ses hobbies dans la base de données
        function insertPersonneHobbies($personneId,$hobbies){
            try{
                foreach($hobbies as $hobby){
                    $requete_prepare=$this->connexion->prepare(
                        "INSERT INTO RelationHobby (Personne_Id,Hobby_Id) values (:id,:hobby)"
                    );
                    $requete_prepare->execute(array("id" => $personneId, "hobby" => $hobby));
                    // echo "Bien inséré"  . $personneId . "avec" . $hobby_Id ."<br>";
                }
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }

        }

// Fonction insertPersonneMusique qui fait la relation entre une personne et ses types de musique préférés dans la base de données
        function insertPersonneMusique($personneId,$musiques){
            try{
                foreach($musiques as $music){
                    $requete_prepare=$this->connexion->prepare(
                        "INSERT INTO RelationMusique (Personne_Id,Musique_Id) values (:id,:music)"
                    );
                    $requete_prepare->execute(array("id" => $personneId, "music" => $music));
                    // echo "Bien inséré" . $personneId . "avec" . $music_Id . "<br>";
                }
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }

        }

// Fonction insertPersonneRelation qui fait la relation entre une personne et ses amis déjà existants dans la base de données
        function insertPersonneRelation($personneId1,$personneId2,$type){
            try{
                $requete_prepare=$this->connexion->prepare(
                    "INSERT INTO RelationPersonne (Personne_Id,Relation_Id,Type) values (:id,:rel,:typ)"
                );
                $requete_prepare->execute(array("id" => $personneId1, "rel" => $personneId2, "typ" => $type));
                $requete_prepare=$this->connexion->prepare(
                    "INSERT INTO RelationPersonne (Personne_Id,Relation_Id,Type) values (:id,:rel,:typ)"
                );
                $requete_prepare->execute(array("id" => $personneId2, "rel" => $personneId1, "typ" => $type));
                // echo "Bien inséré <br>";
            }
            catch(Exception $e){
                echo 'Erreur : '.$e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                return false;
            }

        }

    }
?>