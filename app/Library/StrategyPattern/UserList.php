<?php
namespace App\Library\StrategyPattern;

class UserList
{
    private $list = [];

    public function __construct( $names )
    {
        if (is_array($names)){
            $this->list = $names;
        }
    }

    public function add( $name )
    {
        $this->list[] = $name;
    }

    public function find( $filter )
    {
        $recs = array();
        foreach( $this->list as $user )
        {
            if ( $filter->filter( $user ) ) {
                $recs []= $user;
            }
        }
        return $recs;
    }
}
