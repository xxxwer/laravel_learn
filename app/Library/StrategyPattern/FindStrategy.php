<?php
namespace App\Library\StrategyPattern;

class FindStrategy implements Strategy
{
  private $cmp_str;

  public function __construct( $cmp_str )
  {
    $this->cmp_str = $cmp_str;
  }

  public function filter( $record )
  {
    return strcasecmp( $this->cmp_str, $record ) == 0;
  }
}
