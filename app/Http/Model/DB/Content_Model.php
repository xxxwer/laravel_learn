<?php

namespace App\Http\Model\DB;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Content_Model extends Model
{

    protected $table = 'content';
    protected $primaryKey = 'id';

    public function __construct()
    {

    }

    /**
     * 默认使用时间戳戳功能
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 获取当前时间
     *
     * @return int
     */
    public function freshTimestamp() {
        return time();
    }

    /**
     * 避免转换时间戳为时间字符串
     *
     * @param DateTime|int $value
     * @return DateTime|int
     */
    public function fromDateTime($value) {
        return $value;
    }

    /**
     * select的时候避免转换时间为Carbon
     *
     * @param mixed $value
     * @return mixed
     */
     protected function asDateTime($value) {
          return $value;
     }

    /**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
    public function getDateFormat() {
        return 'U';
    }


}
