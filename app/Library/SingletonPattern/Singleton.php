<?php
namespace App\Library\SingletonPattern;

class Singleton
{
    private static $instance;
    private function __construct(){}
  
    public static function getInstance() {
        if (empty($instance)) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }

    public function showMessage(){
        echo("Hello World!\n");
    }
}
