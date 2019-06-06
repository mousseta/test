<?php
class Dao{
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=association';
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
         Dao::$monPdo = new PDO(Dao::$serveur.';'.Dao::$bdd, Dao::$user, Dao::$mdp);
        
        
    }
    //Design pattern singleton
    public  static function getPdoGsb(){
        //On verifie que la connection n'a pas ete ouverte une premiere fois
        if(Dao::$monPdoGsb==null){
            Dao::$monPdoGsb= new Dao();
        }
        return Dao::$monPdoGsb;
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
        Dao::$monPdo->exec($req);
        
        
    } */
    
    //ajoute un User
    /* public function ajouterUser(User $user){
        
        $nom=$user->getNom();
        $prenom=$user->getPrenom();
        $datenaissance=$user->getDatenaissance();
        $login=$user->getLogin();
        $password=$user->getPassword();
        $email=$user->getEmail();
        $req = "insert into user(nom,prenom,datenaissance,login,password,email)  values (:nom,:prenom,:datenaissance,:login,:password,:email)";
        try{
        $stmt = Dao::$monPdo->prepare($req);
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
     */

    
    
    public function ajouterUser(User $user){
        
        $nom=$user->getNom();
        $prenom=$user->getPrenom();
        $datenaissance=$user->getDatenaissance();
        $login=$user->getLogin();
        $password=$user->getPassword();
        $email=$user->getEmail();
        $req = "insert into user(nom,prenom,datenaissance,login,password,email) values (:nom,:prenom,:datenaissance,:login,:password,:email)";
        //Le try permet de gerer les exceptions si erreur dans le bloc try, alors catch se declenche.
        try{
            $stmt=Dao::$monPdo->prepare($req);
            $stmt->bindParam(':nom',$nom);
            $stmt->bindParam(':prenom',$prenom);
            $stmt->bindParam(':datenaissance',$datenaissance);
            $stmt->bindParam(':login',$login);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':email',$email);
            $stmt->execute();
        }catch(Exception $e){
            echo "Erreur!".$e->getMessage();
            //Comme ca on evite d'afficher des infos sur la base de donnée
                 }
                
                
             }
    
    
    public function getInfosUser($login, $mdp){
        $user=null;
        $req = "select id,nom,prenom,datenaissance,login,password,email from user
		where user.login='$login' and user.password='$mdp'";
        $rs = Dao::$monPdo->query($req);
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
    
    
/*     public function getInfosUser($login, $mdp){
        $user=null;
        $req = "select id,nom,prenom,datenaissance,login,password,email from user
		where user.login=:login and user.password=:password";
        $stmt=Dao::$monPdo->prepare($req);
        $stmt->bindParam(':login',$login);
        $stmt->bindParam(':password',$mdp);
        $stmt->execute();
        $resultat = $stmt->fetchAll();
        foreach( $resultat as $laLigne ) {
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
        }
        return $user;
    } */
    
    
    /* public function getInfosUser($login, $mdp){
        $user=null;
        $req = "select id,nom,prenom,datenaissance,login,password,email from user
		where user.login=:login and user.password=:password";
        $stmt=Dao::$monPdo->prepare($req);
        $stmt->bindParam(':login',$login);
        $stmt->bindParam(':password',$password);
        $stmt->execute();
        $laLigne = $stmt->fetchAll(PDO::FETCH_BOTH);
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
     */
    
    //recupere les utilisateurs
    public function getLesUtilisateur(){
        $liste=array();
        $req = "select id,nom,prenom,datenaissance,login,password,email,nom from  user ";
        $res = Dao::$monPdo->query($req);
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
    public function verifierUser(User $user){
        $req = "select id,nom,prenom,datenaissance,login,password,email,nom from  user ";
        $res = Dao::$monPdo->query($req);
        $laLigne = $res->fetch();
        //on initialise la variable booleenne $existeuser à false
        $existeuser=false;
        //On va boucler sur le jeu d'enregistrement tant que 
        //on n'est pas à la fin et que $existeuser est faux
        while($laLigne != null && (!$existeuser))	{
            $id=$laLigne['id'];
            $nom= $laLigne['nom'];
            $prenom= $laLigne['prenom'];
            $datenaissance= $laLigne['datenaissance'];
            $login= $laLigne['login'];
            $password= $laLigne['password'];
            $email= $laLigne['email'];
            $user1=new User($nom,$prenom,$datenaissance,$login,$password,$email);
            $user1->setId($id);
            //On compare le $user1 construit à partir de la base
            //avec le $user construit a partir du formulaire 
            //et passé comme paramétre à la méthode
            if ($user1->equals($user)) $existeuser=true;
            $laLigne = $res->fetch();
        }
        //on renvoie true ou false
        return $existeuser;
    }
    
    //recupere les utilisateurs
    public function getArticleById($id){
        $post=null;
        $req = "select a.id as id1,titre,date,idauteur,article,nom from  article a ,user u where a.idauteur=u.id and a.id=$id";
        $stmt = Dao::$monPdo->prepare($req);
        $res=$stmt->execute();
        while ($laLigne = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id= $laLigne[0];
            $titre= $laLigne[1];
            $date= $laLigne[2];
            $idauteur= $laLigne[3];
            $article= $laLigne[4];
            $nom= $laLigne[5];
            $post=new Article($titre,$date,$idauteur,$article);
            $post->setId($id);
            $post->setNom($nom);
        }
        return $post;
    }
    
    //recupere les utilisateurs
/*     public function getLesarticles(){
        $liste=array();
        $req = "select a.id as id1,titre,date,idauteur,article,nom from  article a ,user u where a.idauteur=u.id";
        $res = Dao::$monPdo->query($req);
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
        $stmt = Dao::$monPdo->prepare($req);
        $res=$stmt->execute();
        while ($laLigne = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id=$laLigne[0];
            $titre= $laLigne[1];
            $date= $laLigne[2];
            $idauteur= $laLigne[3];
            $article= $laLigne[4];
            $nom= $laLigne[5];
            $post=new Article($titre,$date,$idauteur,$article);
            $post->setId($id);
            $post->setNom($nom);
            $liste[]=$post;
        }
        return $liste;
    }
    public function ajouterArticle(Article $article){
        
        $titre=$article->getTitre();
        $date=$article->getDate();
        $idauteur=$article->getIdauteur();
        $article=$article->getArticle();
        $req = "insert into article(titre,date,idauteur,article) values (:titre,:date,:idauteur,:article)";
        //Le try permet de gerer les exceptions si erreur dans le bloc try, alors catch se declenche.
        try{
            $stmt=Dao::$monPdo->prepare($req);
            $stmt->bindParam(':titre',$titre);
            $stmt->bindParam(':date',$date);
            $stmt->bindParam(':idauteur',$idauteur);
            $stmt->bindParam(':article',$article);
            $stmt->execute();
        }catch(Exception $e){
            $this->ecrirefichier("Erreur!".$e->getMessage());
            //Comme ca on evite d'afficher des infos sur la base de donnée
        }
        
        
    }
    public function ecrirefichier($texte){
        $fichier=fopen("log.txt",'w+');
        fwrite($fichier,$texte);
        fclose($fichier);
    }
    
}
