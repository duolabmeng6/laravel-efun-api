<?php

namespace App\Http\Requests;

use App\异常处理\业务异常;
use App\帮助类\API返回格式类;
use App\帮助类\返回状态码;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class 基础请求验证类 extends FormRequest
{
    use API返回格式类;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @throws 业务异常
     */
    protected function failedValidation(Validator $validator)
    {
        $errorMsg = $validator->errors()->first();
        // 将空格和句号替换成空
        $info = str_replace([' ', '。'],'',$errorMsg);
        $this->抛出异常(返回状态码::参数错误, $info);
    }
}
