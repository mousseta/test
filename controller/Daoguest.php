<?php
class Daoguest{
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=associationguest';
    //POur lma securite ne pas utiliser le super-administrateur
    private static $user='mousse' ;
    private static $mdp='123456' ;
    private static $monPdo;
    private static $monPdoGsb=null;
    
    /**
     * @return string
     */

    //Pour utiliser le pattern singleton on défini le constructeur comme private
    //COmme cela on ne l'utilise pas dans une autre classe.
    private function __construct(){
         Daoguest::$monPdo = new PDO(Daoguest::$serveur.';'.Daoguest::$bdd, Daoguest::$user, Daoguest::$mdp);
        
        
    }
    //Design pattern singleton
    public  static function getPdoGsb(){
        //On verifie que la connection n'a pas ete ouverte une premiere fois
        if(Daoguest::$monPdoGsb==null){
            Daoguest::$monPdoGsb= new Daoguest();
        }
        return Daoguest::$monPdoGsb;
    }
    public function initdb(){
        $article="DROP TABLE IF EXISTS article; CREATE TABLE article (id int(5) NOT NULL AUTO_INCREMENT,titre varchar(80) DEFAULT NULL, date date DEFAULT NULL,idauteur int(5) DEFAULT NULL, article text, PRIMARY KEY (id));";
        $user="DROP TABLE IF EXISTS user;CREATE TABLE user (id int(5) NOT NULL AUTO_INCREMENT,nom varchar(30) NOT NULL,prenom varchar(30) NOT NULL,datenaissance date DEFAULT NULL,login varchar(10) NOT NULL,password varchar(10) NOT NULL,email varchar(60) NOT NULL, PRIMARY KEY (id));"; 
        try{
            $stmt = Daoguest::$monPdo->prepare($article);
            $stmt->execute();
        }
            catch(Exception $e){
                // en cas d'erreur :
                echo " Erreur ! ".$e->getMessage();
            }
            try{
                $stmt = Daoguest::$monPdo->prepare($user);
                $stmt->execute();
            }
            catch(Exception $e){
                // en cas d'erreur :
                echo " Erreur ! ".$e->getMessage();
            }
    }
    
    //ajoute un User
/*     public function ajouterUser(User $user){
        
        $nom=$user->getNom();
        $prenom=$user->getPrenom();
        $datenaissance=$user->getDatenaissance();
        $login=$user->getLogin();
        $password=$user->getPassword();
        $email=$user->getEmail();
        $req = "insert into user(nom,prenom,datenaissance,login,password,email)  values ('$nom','$prenom','$datenaissance','$login','$password','$email')";
        Daoguest::$monPdo->exec($req);
        
        
    } */
    
    //ajoute un User
    public function ajouterUser(User $user){
        
        $nom=$user->getNom();
        $prenom=$user->getPrenom();
        $datenaissance=$user->getDatenaissance();
        $login=$user->getLogin();
        $password=$user->getPassword();
        $email=$user->getEmail();
        $req = "insert into user(nom,prenom,datenaissance,login,password,email)  values (:nom,:prenom,:datenaissance,:login,:password,:email)";
        try{
        $stmt = Daoguest::$monPdo->prepare($req);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':datenaissance', $datenaissance);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        }
        catch(Exception $e){
            // en cas d'erreur :
            echo " Erreur ! ".$e->getMessage();
        }
        
    }
    

    
    public function getInfosUser($login, $mdp){
        $user=null;
        $req = "select id,nom,prenom,datenaissance,login,password,email from user
		where user.login='$login' and user.password='$mdp'";
        $rs = Daoguest::$monPdo->query($req);
        $laLigne = $rs->fetch();
        if ($laLigne != null)	{
            $id=$laLigne['id'];
            $nom= $laLigne['nom'];
            $prenom= $laLigne['prenom'];
            $datenaissance= $laLigne['datenaissance'];
            $login= $laLigne['login'];
            $password= $laLigne['password'];
            $email= $laLigne['email'];
            $user=new User($nom,$prenom,$datenaissance,$login,$password,$email);
            $user->setId($id);
        }
        return $user;
    }
    
    
    //recupere les utilisateurs
    public function getLesUtilisateur(){
        $liste=array();
        $req = "select id,nom,prenom,datenaissance,login,password,email,nom from  user ";
        $res = Daoguest::$monPdo->query($req);
        $laLigne = $res->fetch();
        while($laLigne != null)	{
            $id=$laLigne['id'];
            $nom= $laLigne['nom'];
            $prenom= $laLigne['prenom'];
            $datenaissance= $laLigne['datenaissance'];
            $login= $laLigne['login'];
            $password= $laLigne['password'];
            $email= $laLigne['email'];
            $user=new User($nom,$prenom,$datenaissance,$login,$password,$email);
            $user->setId($id);
            $liste[]=$user;
            $laLigne = $res->fetch();
        }
        return $liste;
    }
    
    //recupere les utilisateurs
/*     public function getLesarticles(){
        $liste=array();
        $req = "select a.id as id1,titre,date,idauteur,article,nom from  article a ,user u where a.idauteur=u.id";
        $res = Daoguest::$monPdo->query($req);
        $laLigne = $res->fetch();
        while($laLigne != null)	{
            $id=$laLigne['id1'];
            $titre= $laLigne['titre'];
            $date= $laLigne['date'];
            $idauteur= $laLigne['idauteur'];
            $article= $laLigne['article'];
            $nom= $laLigne['nom'];
            $post=new Article($id,$titre,$date,$idauteur,$article,$nom);
            $post->setId($id);
            $liste[]=$post;
            $laLigne = $res->fetch();
        }
        return $liste;
    } */
    
    public function getLesarticles(){
        $liste=array();
        $req = "select a.id as id1,titre,date,idauteur,article,nom from  article a ,user u where a.idauteur=u.id";
        $stmt = Daoguest::$monPdo->prepare($req);
        $res=$stmt->execute();
        while ($laLigne = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id=$laLigne[0];
            $titre= $laLigne[1];
            $date= $laLigne[2];
            $idauteur= $laLigne[3];
            $article= $laLigne[4];
            $nom= $laLigne[5];
            $post=new Article($id,$titre,$date,$idauteur,$article,$nom);
            $post->setId($id);
            $liste[]=$post;
        }
        return $liste;
    }
    
}
