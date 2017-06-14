<?php
namespace App\Library\CommandPattern;

use Exception;

class CommandChain
{
    private $commands = [];

    public function addCommand($cmd)
    {
        foreach ($cmd->method as $method) {
            $this->commands[$method]= $cmd;
        }
    }

    public function runCommand($method, $args)
    {
        try {
            if (empty($this->commands[$method])) {
                throw new Exception("this command $method is not exist", 1);
            }
            $cmd = $this->commands[$method];
            $cmd->$method($args);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
