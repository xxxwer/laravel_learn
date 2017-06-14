<?php

namespace App\Http\Model\DB;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Garbage_Info_Filter_Model extends Model
{

    protected $table = 'garbage_info_filter';
    protected $primaryKey = 'word';

    /**
     * 默认使用时间戳戳功能
     *
     * @var bool
     */
    public $timestamps = false;
}
