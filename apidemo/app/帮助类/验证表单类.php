<?php


namespace App\帮助类;


use App\帮助类\返回状态码;
use App\异常处理\业务异常;
use Illuminate\Validation\Rule;

trait 验证表单类
{
    use API返回格式类;

    /**
     * 验证ID
     * @param $key
     * @param null $default
     * @return mixed|null
     * @throws 业务异常
     */
    public function 验证Id($key, $default=null)
    {
        return $this->验证自定义数据($key, $default, 'integer|digits_between:1,20');
    }

    /**
     * 验证是否为整数
     * @param $key
     * @param null $default
     * @return mixed|null
     * @throws 业务异常
     */
    public function 验证是否为整数($key, $default=null)
    {
        return $this->验证自定义数据($key, $default, 'integer');
    }

    /**
     * 验证是否为数字
     * @param $key
     * @param null $default
     * @return mixed|null
     * @throws 业务异常
     */
    public function 验证是否为数字($key, $default=null)
    {
        return $this->验证自定义数据($key, $default, 'numeric');
    }

    /**
     * 验证是否为字符串
     * @param $key
     * @param null $default
     * @return mixed|null
     * @throws 业务异常
     */
    public function 验证是否为字符串($key, $default=null)
    {
        return $this->验证自定义数据($key, $default, 'string');
    }

    /**
     * 验证是否为布尔值
     * @param $key
     * @param null $default
     * @return mixed|null
     * @throws 业务异常
     */
    public function 验证是否为布尔值($key, $default=null)
    {
        return $this->验证自定义数据($key, $default, 'boolean');
    }

    /**
     * 验证是否为枚举
     * @param $key
     * @param null $default
     * @param array $enum
     * @return mixed|null
     * @throws 业务异常
     */
    public function 验证是否为Enum($key, $default=null, array $enum=[])
    {
        return $this->验证自定义数据($key, $default, Rule::in($enum));
    }

    /**
     * 自定义校验参数
     * @param $key string 字段
     * @param $default string 默认值
     * @param $rule string 验证规则
     * @return mixed|null
     * @throws 业务异常
     */
    public function 验证自定义数据($key, $default, $rule)
    {
        $value = request()->input($key, $default);
        $validator = \Validator::make([$key => $value], [$key => $rule]);
        if (is_null($value)){
            $this->抛出异常(返回状态码::参数错误);
        }
        if ($validator->fails()){
            $this->抛出异常(返回状态码::参数错误, $validator->errors()->first());
        }
        return $value;
    }

}
