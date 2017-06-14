<?php

namespace App\Services;

use App\Contracts\TestContract;

class TestService implements TestContract
{
    public function __construct()
    {
        echo 'aaaa bbb ccc ';
    }

    public function callMe($controller)
    {
        echo ('Call Me From TestServiceProvider In '.$controller . '<hr>');
    }
}
