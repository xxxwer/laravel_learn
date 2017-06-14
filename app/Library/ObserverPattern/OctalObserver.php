<?php
namespace App\Library\ObserverPattern;

class OctalObserver extends Observer
{
    public function __construct($subject){
        $this->subject = $subject;
        $this->subject->attach($this);
    }

    public function update() {
        echo('Binary String: ' . decoct($this->subject->getState()) . "\n");
    }
}