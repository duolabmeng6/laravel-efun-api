<?php


namespace App\帮助类;

use App\帮助类\返回状态码;
use App\异常处理\业务异常;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


trait API返回格式类
{
    /**
     * 成功
     * @param null $data
     * @param array $codeResponse
     * @return JsonResponse
     */
    public function 成功($data = null, $codeResponse=返回状态码::操作成功): JsonResponse
    {
        return $this->返回json('success', $codeResponse, $data, null);
    }

    /**
     * 失败
     * @param array $codeResponse
     * @param null $data
     * @param null $error
     * @return JsonResponse
     */
    public function 失败($codeResponse=返回状态码::请求失败, $data = null, $error=null): JsonResponse
    {
        return $this->返回json('fail', $codeResponse, $data, $error);
    }

    /**
     * 返回json
     * @param $status
     * @param $codeResponse
     * @param $data
     * @param $error
     * @return JsonResponse
     */
    private function 返回json($status, $codeResponse, $data, $error): JsonResponse
    {
        list($code, $message) = $codeResponse;
        return response()->json([
            'status'  => $status,
            'code'    => $code,
            'message' => $message,
            'data'    => $data ?? null,
            'error'  => $error,
        ]);
    }


    /**
     * 成功分页返回
     * @param $page
     * @return JsonResponse
     */
    protected function 成功分页($page): JsonResponse
    {
        return $this->成功($this->分页($page));
    }

    private function 分页($page)
    {
        if ($page instanceof LengthAwarePaginator){
            return [
                'total'  => $page->total(),
                'page'   => $page->currentPage(),
                'limit'  => $page->perPage(),
                'pages'  => $page->lastPage(),
                'list'   => $page->items()
            ];
        }
        if ($page instanceof Collection){
            $page = $page->toArray();
        }
        if (!is_array($page)){
            return $page;
        }
        $total = count($page);
        return [
            'total'  => $total, //数据总数
            'page'   => 1, // 当前页码
            'limit'  => $total, // 每页的数据条数
            'pages'  => 1, // 最后一页的页码
            'list'   => $page // 数据
        ];
    }

    /**
     * 业务异常返回
     * @param array $codeResponse
     * @param string $info
     * @throws 业务异常
     */
    public function 抛出异常(array $codeResponse=返回状态码::请求失败, string $info = '')
    {
        throw new 业务异常($codeResponse, $info);
    }
}
