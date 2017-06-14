<?php
namespace App\Library\AbstractFactoryPattern;

class ShapeFactory extends AbstractFactory 
{
    public function getShape($shape){
        if(empty($shape)){
            return null;
        }

        if(strcasecmp($shape, "RECTANGLE") == 0){
            return new Rectangle();
        }elseif (strcasecmp($shape, "SQUARE") == 0){
            return new Square();
        }

        return null;
    }

    public function getColor($color){
        return null;
    }
}
