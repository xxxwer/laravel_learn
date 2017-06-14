<?php
namespace App\Library\StrategyPattern;

class RandomStrategy implements Strategy
{
  public function filter( $record )
  {
    return rand( 0, 1 ) >= 0.5;
  }
}