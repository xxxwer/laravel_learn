<?php
namespace App\Library\StrategyPattern;

interface Strategy
{
    public function filter( $record );
}