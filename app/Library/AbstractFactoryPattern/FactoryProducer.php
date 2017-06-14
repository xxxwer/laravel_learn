<?php
namespace App\Library\AbstractFactoryPattern;

class FactoryProducer 
{
    public static function getFactory($choice){
        if(strcasecmp($choice, "SHAPE") == 0){
            return new ShapeFactory();
        } elseif(strcasecmp($choice, "COLOR") == 0){
            return new ColorFactory();
        }

        return null;
    }
}
