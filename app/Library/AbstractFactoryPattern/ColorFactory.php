<?php
namespace App\Library\AbstractFactoryPattern;

class ColorFactory extends AbstractFactory 
{
    public function getShape($shape){
       return null;
    }
   
    public function getColor($color){
        if(empty($color)){
            return null;
        }

        if(strcasecmp($color, "RED") == 0){
            return new Red();
        } else if(strcasecmp($color, "GREEN") == 0){
            return new Green();
        }

        return null;
    }
}