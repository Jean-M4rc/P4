<?php
/**
 * Class Posts qui permet de définir les récits du blog
 * 
 * @author Jean-Marc Voisin <jeanmarc.voisin.tai@gmail.com>
 */

 namespace P4\classes;

class Posts{
     
    private $_ID;
    private $_title;
    private $_date_create;
    private $_content;
    private $_resume;

    /**
     * Fonction constructeur
     * 
     * Prend en paramètres un tableau des données pour hydratater l'objet
     * @param array $data
     */
    public function __construct(array $data){

        $this->hydrate($data);
    }

    /**
     * Fonction d'hydratation
     *
     * @param array $data
     */
    private function hydrate(array $data){

        foreach ($donnees as $key => $value){

            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){

                $this->$method($value);
            }
        }
    }

    // LES GETTERS car les attributs sont privés
    public function ID(){
        return $this->_ID;
    }

    public function title(){
        return $this->_title;
    }

    public function date_create(){
        return $this->_date_create;
    }

    public function content(){
        return $this->_content;
    }

    public function resume(){
        return $this->_resume;
    }

    // LES SETTERS. Vérifient l'intégrité des données reçues.

    public function setId($id){

        $id = (int) $id;

        if($id>0){
            $this->_id = $id;
        }
    }

    public function setTitle($title){

        if (is_string($title)){
            $this->_title = $title;
        }
    }

    /**
     * Fonction de création de la date de création du post.
     * Accessible seulement pour l'hydratation donc on passe la méthode en privée
     * @param date $date
     * @return $date
     */
    private function setDate_create($date){
        $date = DateTime::RFC850;
        $this->_date_create = $date;
    }

    public function setContent($content){

        if (is_string($content)){
            $this->_content = $content;
        }
    }

    public function setResume($content){
        if(is_string($content)){
            $resume = strip_tags(substr($content,0,300) . '...','<br>');
            $this->_resume = $resume;
        }
    }



}