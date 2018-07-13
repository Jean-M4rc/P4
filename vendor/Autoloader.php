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
    \spl_autoload_register(array(__CLASS__, 'autoload'));
  }


  static function autoload($class_name){

    echo 'Try to call  ' . $class_name . '.php inside ' . __METHOD__ . '<br>';
        $classfileController = BASEPATH . '\\controller\\' . $class_name . '.php';
        $classfileModel = BASEPATH . '\\model\\' . $class_name . '.php';
        if ( is_file( $classfileController ) ) {
          echo $classfileController . '<br/>';
            require( $classfileController );
        } else if ( is_file( $classfileModel ) ){
          echo $classfileModel . '<br/>';
          require( $classfileModel );
        } 
    
  }
}