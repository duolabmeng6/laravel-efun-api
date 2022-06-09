<?php

namespace App\Services;

use App\帮助类\API返回格式类;

class 基础服务类
{
    // 引入api统一返回消息
    use API返回格式类;


    protected static $instance;

    public static function getInstance()
    {
        if (static::$instance instanceof static){
            return self::$instance;
        }
        static::$instance = new static();
        return self::$instance;
    }
    public static function 取单例对象()
    {
        if (static::$instance instanceof static){
            return self::$instance;
        }
        static::$instance = new static();
        return self::$instance;
    }

    protected function __construct(){}

    protected function __clone(){}


}
