<?php
namespace App\Library\BuilderPattern;

abstract class Burger implements Item
{
   public function packing() {
      return new Wrapper();
   }

   abstract public function price();
}
