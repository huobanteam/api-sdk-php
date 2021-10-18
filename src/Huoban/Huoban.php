<?php
/*
 * @Author: ZhaohangYang <yangzhaohang@comsenz-service.com>
 * @Date: 2021-05-25 10:26:41
 * @Description: 伙伴智慧大客户研发部
 */

namespace Huoban;

class Huoban implements Factory
{

    protected $models = [];

    protected $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    public function create($model)
    {
        return $this->models[$model] = $this->resolve($model);
    }

    protected function resolve($model) {
        $model = '\\Huoban\\Models\\Huoban'.ucfirst($model);

        return new $model(new GuzzleRequest($this->config));
    }
}
