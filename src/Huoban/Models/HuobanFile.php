<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

class HuobanFile
{
    public $interfaceType = 'upload';
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    /**
     * 上传文件
     *
     * @param array $body
     * @param array $options
     * @return void
     */
    public function upload($body = [], $options = [])
    {
        //  example

        //  $body = [
        //      'multipart' => [
        //          [
        //              'contents' => fopen($file_path . '/' . $file_name, 'r'),
        //              'name'     => 'source',
        //          ],
        //          [
        //              'name'     => 'type',
        //              'contents' => 'attachment',
        //          ],
        //          [
        //              'name'     => 'name',
        //              'contents' => $file_name,
        //          ],
        //      ],
        //  ];

        $response = $this->request->getHttpClient($this->interfaceType)->request('POST', "/file", $body, $options);
        return json_decode($response->getBody(), true);
    }
}
