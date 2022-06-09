<?php

namespace App\Services;

use App\帮助类\返回状态码;
use App\Models\User;
use App\Services\基础服务类;

class 用户服务类 extends 基础服务类
{
    public function 注册(array $params)
    {
        $user = User::query()->create([
            'mobile' => $params['mobile'],
            'password' => bcrypt($params['password']),
        ]);
        if (!$user){
            $this->抛出异常(返回状态码::注册失败);
        }
    }

    // 获取用户信息
    public function 获取用户信息(array $user)
    {
        return ['id' => 1, 'nickname' => '张三', 'age' => 18];
    }

}
