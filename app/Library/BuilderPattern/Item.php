<?php
namespace App\Library\BuilderPattern;

interface Item {
   public function name();
   public function packing();
   public function price();
}
