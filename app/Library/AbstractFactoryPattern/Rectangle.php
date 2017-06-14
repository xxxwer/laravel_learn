<?php
namespace App\Library\AbstractFactoryPattern;

class Rectangle implements Shape 
{
   public function draw() {
      echo "Inside Rectangle::draw() method.\n";
   }
}
