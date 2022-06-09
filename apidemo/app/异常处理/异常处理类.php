<?php

namespace App\异常处理;

use App\帮助类\API返回格式类;
use App\帮助类\返回状态码;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class 异常处理类 extends ExceptionHandler
{
    use API返回格式类;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // 如果是生产环境则返回500
        if (!config('app.debug')) {
            $this->抛出异常(返回状态码::服务器错误);
        }
        // 请求类型错误异常抛出
        if ($exception instanceof MethodNotAllowedHttpException) {
            $this->抛出异常(返回状态码::HTTP请求类型错误);
        }
        // 参数校验错误异常抛出
        if ($exception instanceof ValidationException) {
            $this->抛出异常(返回状态码::参数错误);
        }
        // 路由不存在异常抛出
        if ($exception instanceof NotFoundHttpException) {
            $this->抛出异常(返回状态码::没有找到该页面);
        }
        // 自定义错误异常抛出
        if ($exception instanceof 业务异常) {
            return response()->json([
                'status'  => 'fail',
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
                'data'    => null,
                'error'  => null,
            ]);
        }
        return parent::render($request, $exception);
    }
}
