<?php
namespace App\Library\ObserverPattern;

class ObserverPatternTest
{
    public function do() {
        $subject = new Subject();

        new HexaObserver($subject);
        new OctalObserver($subject);
        new BinaryObserver($subject);

        echo("First state change: 15\n");
        $subject->setState(15);
        echo("Second state change: 10\n");
        $subject->setState(10);
    }
}
