<?php
namespace App\Library\AbstractFactoryPattern;

class Square implements Shape
{
   public function draw() {
      echo "Inside Square::draw() method.\n";
   }
}