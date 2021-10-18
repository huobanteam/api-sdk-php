<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

/**
 * BI 文件上传
 */
class HuobanBiFile
{
    /**
     * 请求类型
     *
     * @var string
     */
    public $interfaceType = 'bi';
    
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    /**
     * 上传数据仓库数据文件（用于创建数据仓库表数据）
     *
     * @param array $body
     * @param array $options
     * @return void
     */
    public function upload($body = [], $options = [])
    {
        //  example

        //   $body = [
        //        'multipart' => [
        //            [
        //                'contents' => fopen('/storage/test.data', 'r'), // test.data:每一行是一个json,{字段别名:字段值....},\n结尾
        //                'name'     => 'source',
        //            ],
        //            [
        //                'name'     => 'type',
        //                'contents' => 'create / update',
        //            ],
        //            [
        //                'name'     => 'table_alias',
        //                'contents' => $table_alias,
        //            ],
        //            [
        //                'name'     => 'space_id',
        //                'contents' => $space_id,
        //            ],
        //        ],
        //  ];

        try {
            $response = $this->request->getHttpClient($this->interfaceType)->request('POST', '/v2/app_sync/file', $body, $options);
            $response = json_decode($response->getBody(), true);
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        }
        return $response;

    }
}
