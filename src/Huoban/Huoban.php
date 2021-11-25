<?php
/*
 * @Author: ZhaohangYang <yangzhaohang@comsenz-service.com>
 * @Date: 2021-05-25 10:26:41
 * @Description: 伙伴智慧大客户研发部
 */

namespace Huoban;

use Exception;
use Huoban\Models\HuobanTicket;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

class Huoban implements Factory
{

    protected $models = [];

    protected $config;

    protected $cache;

    public function __construct($config = [], CacheInterface $cache = null)
    {
        $this->config = $config + [
            'name'               => 'huoban',
            'alias_model'        => true,
            'space_id'           => '',
            'urls' => [
                'api' => 'https://api.huoban.com',
                'upload' => 'https://upload.huoban.com',
                'bi' => 'https://bi.huoban.com',
            ],
        ];
        $this->cache = $cache;
    }

    public function create($model)
    {
        return $this->models[$model] = $this->resolve($model);
    }

    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    protected function resolve($model)
    {
        $model = '\\Huoban\\Models\\Huoban' . ucfirst($model);

        $request = new GuzzleRequest($this->config);

        if (isset($this->config['application_id']) && isset($this->config['application_secret'])) {

            if(is_null($this->cache)) {
                $cache = new FilesystemAdapter();

                $cache = new Psr16Cache($cache);
                $this->cache = $cache;
            }

            HuobanTicket::setCache($this->cache);

            $ticket = new HuobanTicket($request);
            $ticket = $ticket->getTicket($this->config);

            $request->setConfig('ticket', $ticket);
        }

        return new $model($request);
    }
}
