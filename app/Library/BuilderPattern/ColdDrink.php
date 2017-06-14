<?php
namespace App\Library\BuilderPattern;

abstract class ColdDrink implements Item
{
    public function packing() {
       return new Bottle();
    }

    abstract public function price();
}
