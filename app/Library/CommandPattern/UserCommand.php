<?php
namespace App\Library\CommandPattern;

class UserCommand implements Command
{
    public $method = ['addUser', 'deleteUser'];

    public function addUser($args){
        var_dump($args);
        echo("\naddUser... done\n");
    }

    public function deleteUser($args){
        var_dump($args);
        echo("\ndeleteUser... done\n");
    }
}
