<?php
namespace App\Library\BuilderPattern;

class Wrapper implements Packing 
{
    public function pack() {
        return "Wrapper";
    }
}
