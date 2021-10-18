<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

class HuobanSpace
{
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    public function getSpaceRequest($space_id, $body = [], $options = [])
    {
        return $this->request->getRequest('GET', "/space/{$space_id}", $body, $options);
    }
    public function getSpace($space_id, $body = [], $options = [])
    {
        return $this->request->execute('GET', "/space/{$space_id}", $body, $options);
    }
}
