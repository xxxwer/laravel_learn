<?php
namespace App\Library\ObserverPattern;

class HexaObserver extends Observer
{
    public function __construct($subject){
        $this->subject = $subject;
        $this->subject->attach($this);
    }

    public function update() {
        echo('Hex String: ' . dechex($this->subject->getState()) . "\n");
    }
}
