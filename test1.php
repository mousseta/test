<?php
require("modele/Article.php");
require("controller/Dao.php");
$dao=Dao::getPdoGsb();
$liste=$dao->getLesArticles();
foreach($liste as $article){
    echo "titre : ".$article->getTitre()."</br>";
    echo "date : ".$article->getDate()."</br>";
    echo "auteur : ".$article->getIdauteur()."</br>";
    echo "article : ".$article->getArticle()."</br>";
}