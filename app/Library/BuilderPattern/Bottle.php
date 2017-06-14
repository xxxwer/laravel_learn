<?php
namespace App\Library\BuilderPattern;

class Bottle implements Packing 
{
    public function pack() {
        return "Bottle";
    }
}
