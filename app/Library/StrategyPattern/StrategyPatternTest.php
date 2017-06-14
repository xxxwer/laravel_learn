<?php
namespace App\Library\StrategyPattern;

class StrategyPatternTest
{
    public function do()
    {
        $ul = new UserList( array( "Andy", "Jack", "Lori", "Megan" ) );
        $f1 = $ul->find( new FindStrategy( "Jack" ) );
        print_r( $f1 );

        $f2 = $ul->find( new RandomStrategy() );
        print_r( $f2 );
    }
}
