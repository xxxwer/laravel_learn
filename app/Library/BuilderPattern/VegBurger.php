<?php
namespace App\Library\BuilderPattern;

class VegBurger extends Burger
{
   public function price() {
      return 25.0;
   }

   public function name() {
      return "Veg Burger";
   }
}
