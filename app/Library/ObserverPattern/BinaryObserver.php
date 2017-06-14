<?php
namespace App\Library\ObserverPattern;

class BinaryObserver extends Observer
{
    public function __construct($subject){
        $this->subject = $subject;
        $this->subject->attach($this);
    }

    public function update() {
        echo('Binary String: ' . decbin($this->subject->getState()) . "\n");
    }
}