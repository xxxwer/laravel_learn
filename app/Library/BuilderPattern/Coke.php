<?php
namespace App\Library\BuilderPattern;

class Coke extends ColdDrink
{
   public function price() {
      return 30.0;
   }

   public function name() {
      return "Coke";
   }
}
