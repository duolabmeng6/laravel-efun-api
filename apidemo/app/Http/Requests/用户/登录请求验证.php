<?php

namespace App\Http\Requests\用户;

use App\Http\Requests\基础请求验证类;

class 登录请求验证 extends 基础请求验证类
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'mobile' => 'required|regex:/^1[^0-2]\d{9}$/|exists:App\Models\User,mobile',
            'password' => 'required|string|min:6|max:20',
        ];
    }

    /**
     * 获取验证错误的自定义属性。
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'mobile' => '手机号',
            'password' => '密码',
        ];
    }


    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mobile.require' => '请输入手机号',
            'password.require' => '请输入密码',
        ];
    }
}
