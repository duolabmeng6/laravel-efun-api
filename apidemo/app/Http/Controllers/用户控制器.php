<?php
namespace App\Http\Controllers;

use App\帮助类\返回状态码;
use App\Http\Requests\用户\登录请求验证;
use App\Http\Requests\用户\注册请求验证;
use App\Models\User;
use App\Services\用户服务类;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class 用户控制器 extends 基础控制器
{
    public function 注册(注册请求验证 $request, 用户服务类 $用户服务类)
    {
        $数据 = $request->all('mobile', 'password');
        $用户服务类->注册($数据);
        return $this->成功($数据, 返回状态码::注册成功);
    }

    public function 登录(登录请求验证 $request)
    {
        $数据 = $request->all('mobile', 'password');
        if (!Auth::attempt($数据)) {
            return $this->失败(返回状态码::登录失败);
        }
        $result['user']  = User::where('mobile', $数据['mobile'])->first();
        $result['token'] = $result['user']->createToken($数据['mobile'], ['*'])->plainTextToken;
        return $this->成功($result, 返回状态码::登录成功);
    }

    public function 退出登录(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->成功(null, 返回状态码::退出登录成功);
    }

    public function 用户信息(Request $request)
    {
        return $this->成功($request->user());
    }
}
