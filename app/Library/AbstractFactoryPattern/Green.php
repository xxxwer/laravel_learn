<?php
namespace App\Library\AbstractFactoryPattern;

class Green implements Color
{
    public function fill() {
        echo "Inside Green::fill() method.\n";
    }
}
