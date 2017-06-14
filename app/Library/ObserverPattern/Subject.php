<?php
namespace App\Library\ObserverPattern;

class Subject
{
    private $observers = [];
    private $state = 0;

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        $this->notifyAllObservers();
    }

    public function attach($observer){
        $this->observers[] = $observer;
    }

    public function notifyAllObservers(){
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
}
