<?php
/*
 * @Author: ZhaohangYang <yangzhaohang@comsenz-service.com>
 * @Date: 2021-05-25 10:26:41
 * @Description: 伙伴智慧大客户研发部
 */

namespace Huoban\Models;

use Closure;
use function GuzzleHttp\json_decode;

/**
 * 伙伴cache 类
 */
class HuobanCache
{
    public $request;
    public $path;
    public function __construct($huoban)
    {
        $this->request = $request;
        $this->setPath();
    }
    /**
     * 设计缓存基础路径
     *
     * @return void
     */
    public function setPath()
    {
        $this->path = $this->request->config['cache_path'] ?? '/tmp/huoban/';
        !is_dir($this->path) && mkdir($this->path, 0777, true);
    }
    /**
     * 设置缓存
     *
     * @param string $name
     * @param void $value
     * @param integer $expired
     * @return void
     */
    public function set($name, $value, $expired = 0)
    {
        $file_name = $this->path . $name;
        $file_data = ['name' => $name, 'value' => $value, 'expired' => $expired, 'create_at' => time()];

        return file_put_contents($file_name, json_encode($file_data));
    }
    /**
     * 获取缓存
     *
     * @param string $name
     * @param void $default_value
     * @return void
     */
    public function get($name, $default_value = null)
    {
        $file_name = $this->path . $name;
        if (!is_file($file_name)) {
            return $default_value;
        }
        $file_data = json_decode(file_get_contents($file_name), true);

        return (time() - $file_data['create_at']) <= $file_data['expired'] ? $file_data['value'] : null;
    }
    /**
     * 获取缓存，获取不到重新生成缓存并返回
     *
     * @param string $name
     * @param int $expired
     * @param concrete $concrete
     * @return void
     */
    public function remember($name, $expired, $concrete)
    {

        $value = $this->get($name);

        if (!$value) {
            $value = $concrete instanceof Closure ? $concrete() : $concrete;
            $this->set($name, $value, $expired);
        }
        return $value;
    }
}
