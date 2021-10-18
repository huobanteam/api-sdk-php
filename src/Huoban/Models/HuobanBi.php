<?php
/*
 * @Author: ZhaohangYang <yangzhaohang@comsenz-service.com>
 * @Date: 2021-05-25 10:26:41
 * @Description: 伙伴智慧大客户研发部
 */

namespace Huoban\Models;

use Huoban\RequestInterface;

/**
 * 伙伴BI基础类
 */
class HuobanBi
{
    /**
     * 伙伴实例
     *
     * @var [\Huoban\Huoban]
     */
    public $request;

    /**
     * 初始化 $_huoban
     *
     * @param Huoban $huoban
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    /**
     * 注册应用同步信息
     *
     * @param array $body
     * @param array $options
     * @return void
     */
    public $interfaceType = 'bi';

    public function register($body = [], $options = [])
    {
        //  example

        //  $body = [
        //      "space_id"    => "4000000002101383",
        //      "table_alias" => "app_alias_bi_demo",
        //      "safeguard"   => [
        //          "type"  => "create_time",
        //          "cycle" => 30,
        //      ],
        //  ];
        $options['interface_type'] = $this->interfaceType;
        $response                  = $this->request->execute('POST', "/app_sync/register", $body, $options);

        return $response;
    }

    /**
     * 即刻执行同步动作，同步上传文件的数据到数据仓库
     *
     * @param array $body
     * @param array $options
     * @return void
     */
    public function sync($body = [], $options = [])
    {
        //  example

        //  $body = [
        //      'type'         => 'calculate(计算字段)/sync(没有计算字段)',
        //      'space_id'     => '4000000002101383',
        //      'sync_version' => '2021-04-21 22:00:00',
        //  ];
        $options['interface_type'] = $this->interfaceType;
        $response                  = $this->request->execute('POST', "/app_sync/data", $body, $options);

        return $response;
    }
}
