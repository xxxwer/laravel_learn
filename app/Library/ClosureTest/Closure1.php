<?php
namespace App\Library\ClosureTest;

use Closure;

class Closure1
{
    public function test(){
        $numberPlus1 = function($num) {
            if (is_numeric($num)) {
                return $num + 1;
            } else {
                return null;
            }
        };

        $numberSquare = function($num) {
            if (is_numeric($num)) {
                return $num * $num;
            } else {
                return null;
            }
        };

        $number8Power = function($num) {
            if (is_numeric($num)) {
                return pow($num, 8);
            } else {
                return null;
            }
        };

        var_dump($this->filter($numberPlus1, [111,22,33,'sdcs','2','sdcs']));
        var_dump($this->filter($numberSquare, [111,22,33,'sdcs','2','sdcs']));
        var_dump($this->filter($number8Power, [111,22,33,'sdcs','2','sdcs']));
    }

    public function filter(Closure $fun, $arr)
    {
        $ret = [];
        foreach ($arr as $v) {
            $temp = $fun($v);
            if (!empty($temp)) {
                $ret[] = $temp;
            }
        }

        return $ret;
    }
}
