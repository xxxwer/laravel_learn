<?php
namespace App\Library\BuilderPattern;

class ChickenBurger extends Burger
{
   public function price() {
      return 50.5;
   }

   public function name() {
      return "Chicken Burger";
   }
}
