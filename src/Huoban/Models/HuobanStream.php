<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

class HuobanStream
{
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * 获取item动态
     * $body = array(
     *     'limit' => 10,
     *     'last_stream_id' => 11001,
     * );
     */
    public function getRequest($item_id, $body = [], $options = [])
    {
        return $this->request->getRequest('GET', "/streams/item/{$item_id}", $body, $options);
    }
    public function get($item_id, $body = [], $options = [])
    {
        return $this->request->execute('GET', "/streams/item/{$item_id}", $body, $options);
    }
}
