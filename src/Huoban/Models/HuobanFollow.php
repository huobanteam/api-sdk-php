<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

class HuobanFollow
{
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    public function create($item_id, $body = [], $options = [])
    {
        return $this->request->execute('POST', "/follow/item/{$item_id}", $body, $options);
    }
    public function delete($ref_id, $body = [], $options = [])
    {
        return $this->request->execute('POST', "/follow/item/{$ref_id}", $body, $options);
    }
    public function getAll($item_id, $body = [], $options = [])
    {
        return $this->request->execute('POST', "/follow/item/{$item_id}/find", $body, $options);
    }
}
