<?php
namespace App\Library\ObserverPattern;

abstract class Observer {
   protected $subject;
   abstract public function update();
}
