<?php

namespace App\Http\Controllers;

use App\帮助类\API返回格式类;
use App\帮助类\验证表单类;

class 基础控制器 extends Controller
{
    // API接口响应
    use API返回格式类;
    // 验证表单参数输入请求
    use 验证表单类;

    /**
     * Get the token array structure.
     * @param string $token
     * @return string
     */
    protected function respondWithToken(string $token): string
    {
        return 'Bearer '.$token;
    }
}
