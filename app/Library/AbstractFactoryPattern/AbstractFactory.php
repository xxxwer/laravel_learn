<?php 
namespace App\Library\AbstractFactoryPattern;

abstract class AbstractFactory
{
    // 强制要求子类定义这些方法
    abstract protected function getColor($color);
    abstract protected function getShape($shape);

    // 普通方法（非抽象方法）
    public function printOut() {
        print 'test' . "\n";
    }
}
