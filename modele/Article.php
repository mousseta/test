<?php


/**
 * @author mousse
 *
 */
class Article
{
    private $id;
    private $titre;
    private $date;
    private $idauteur;
    private $article;
    private $nom; //nom de l'auteur
    //On enleve la propriété $nom du constructeur car on doit
    //instancier un article uniquement avec les proprietes de
    //correspondant aux champs de la table pour inserer l'objet
    //remarque: cela implique que les methodes qui travaillait avec
    //l'ancien constructeur doivent être revu pour ne pas un avoir
    //des problemes de regression du code (test unitaire)
    public function __construct($titre,$date,$idauteur,$article){
        $this->titre=$titre;
        $this->date=$date;
        $this->idauteur=$idauteur;
        $this->article=$article;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getIdauteur()
    {
        return $this->idauteur;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $idauteur
     */
    public function setIdauteur($idauteur)
    {
        $this->idauteur = $idauteur;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    
    }


    
    


