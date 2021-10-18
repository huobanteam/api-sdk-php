<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

class HuobanNotification
{
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function createRequest($body = [], $options = [])
    {
        return $this->request->getRequest('POST', "/notification", $body, $options);
    }
    public function create($body = [], $options = [])
    {
        return $this->request->execute('POST', "/notification", $body, $options);
    }
}
