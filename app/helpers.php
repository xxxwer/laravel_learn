<?php

function exceptionOperate(Exception $e)
{
    $str = $e->getMessage();
    $strArray = explode(' ', $str);
    if (isTimeStamp(end($strArray))) {
        return view('errors/show_error', array('title' => 'error', 'content' => $str));
    } else {
        throw $e;
    }
}

function isTimeStamp($timeStamp)
{
    //echo strtotime('2038-01-19 03:14:07'); // 2147454847
    return ctype_digit($timeStamp) && $timeStamp <= 2147483647;
}

function assets($path)
{
    return URL::asset($path);
}
