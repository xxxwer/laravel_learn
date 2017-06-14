<?php
namespace App\Library\AbstractFactoryPattern;

class Red implements Color 
{
   public function fill() {
      echo "Inside Red::fill() method.\n";
   }
}