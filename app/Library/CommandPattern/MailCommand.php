<?php
namespace App\Library\CommandPattern;

class MailCommand implements Command
{
    public $method = ['searchMail', 'sendMail'];

    public function searchMail($args){
        var_dump($args);
        echo("\nsearchMail... done\n");
    }

    public function sendMail($args){
        var_dump($args);
        echo("\nsendMail... done\n");
    }
}
