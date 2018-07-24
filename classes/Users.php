<?php
/**
 * Class Users qui permet de réprésenter les utilisateurs du blog
 * 
 * @author Jean-Marc Voisin <jeanmarc.voisin.tai@gmail.com>
*/

namespace P4\classes;

class Users{

    private $_ID;
    private $_login;
    private $_password;
    private $_email;
    private $_date_sign;
    private $_admin;
    private $_country;
    private $_avatar_path;
    private $_ban;

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
        return $this->ID;
    }

    public function login(){
        return $this->login;
    }

    public function password(){
        return $this->password;
    }

    public function email(){
        return $this->email;
    }

    public function date_sign(){
        return $this->date_sign;
    }

    public function admin(){
        return $this->admin;
    }

    public function country(){
        return $this->country;
    }

    public function avatar_path(){
        return $this->avatar_path;
    }

    public function ban(){
        return $this->ban;
    }

}