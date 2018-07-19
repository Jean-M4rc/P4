<?php

//namespace P4\vendor;

/**
 * class Autoloader
 */
class Autoloader{

  /** Enregistre notre autoloader
   * 
   */
  static function register(){
    spl_autoload_register('Autoloader::autoload1');
    spl_autoload_register('Autoloader::autoload2');
  }


  static function autoload1($class_name){

    $file = 'controller/' . $class_name . '.php';

    if(file_exists($file)){

      require_once($file);
    }
  }

  static function autoload2($class_name){

    $file = 'model/' . $class_name . '.php';

    if(file_exists($file)){

      require_once($file);
    }
  }
}