<?php
namespace App\Library\CommandPattern;

class CommandPatternTest
{
    public function do(){
        $c = new CommandChain();
        $c->addCommand( new UserCommand() );
        $c->addCommand( new MailCommand() );
        $c->runCommand( 'addUser', ['aaa', 'bbb'] );
        $c->runCommand( 'deleteUser', [12] );
        $c->runCommand( 'sendMail', [1,2] );
        $c->runCommand( 'searchMail', [1,2] );
        $c->runCommand( 'searchMdscssail', [1,2] );
        die();
    }
}
