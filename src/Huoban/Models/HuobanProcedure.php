<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

class HuobanProcedure
{
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function runProcedureRequest($procedure_id, $body = [], $options = [])
    {
        return $this->request->getRequest('POST', "/procedure/{$procedure_id}/run", $body, $options);
    }
    public function runProcedure($procedure_id, $body = [], $options = [])
    {
        return $this->request->execute('POST', "/procedure/{$procedure_id}/run", $body, $options);
    }
}
