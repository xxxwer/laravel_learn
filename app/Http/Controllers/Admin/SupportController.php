<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;

class SupportController extends Controller
{
    public $session;

    public function __construct()
    {
      $this->session = Session::all();
    }

    public function sessionAndOther($command = null)
    {
        $input = Input::all();

        if ($command == 'csrf') {
            $ret = hash_equals( $this->session['_token'], $input['_token'] );

            Session::put('_token', Str::random(40));

            if ($ret != true) {
                return array('status' => 'error', 'reason' => 'error csrf 1477302323');
            }
            else {
                return array('status' => 'success', 'reason' => '');
            }
        }

    }


}
