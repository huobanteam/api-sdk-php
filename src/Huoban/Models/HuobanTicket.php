<?php
/*
 * @Author: SanQian
 * @Date: 2021-08-18 11:37:13
 * @LastEditTime: 2021-09-07 15:31:17
 * @LastEditors: SanQian
 * @Description:
 * @FilePath: /kuaidi100/vendor/zhaohangyang/huoban_tools_php/src/Models/HuobanTicket.php
 *
 */

namespace Huoban\Models;

use Exception;
use GuzzleHttp\Psr7\Request;
use Huoban\RequestInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class HuobanTicket
{
    public $request;

    protected static $cache;

    /**
     * @throws \Exception
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public static function setCache(CacheInterface $cache) {
        self::$cache = $cache;
    }

    /**
     * 获取企业授权的请求
     *
     * @param [type] $application_id
     * @param [type] $application_secret
     * @param [type] $expired
     * @return Request
     */
    public function getForEnterpriseRequest($application_id, $application_secret, $expired): Request
    {
        $attr = [
            'application_id'     => $application_id,
            'application_secret' => $application_secret,
            'expired'            => $expired,
        ];

        return new Request('POST', '/v2/ticket', [], json_encode($attr));
    }

    /**
     * 获取企业授权的执行操作
     *
     * @param $application_id
     * @param $application_secret
     * @param array $options
     * @return string
     * @throws Exception
     */
    public function getForEnterprise($application_id, $application_secret, array $options = []): string
    {
        $ticket_name = $this->request->config['name'] . '_enterprise_ticket';
        $expired     = $options['expired'] ?? 1209600;

        return $this->remember($ticket_name, $expired - 3600, function () use ($application_id, $application_secret, $expired) {
            $request  = $this->getForEnterpriseRequest($application_id, $application_secret, $expired);
            $response = $this->request->requestJsonSync($request);
            return $response['ticket'];
        });
    }

    /**
     * 获取分享授权的请求
     *
     * @param [type] $share_id
     * @param [type] $secret
     * @param [type] $expired
     * @return Request
     */
    protected function getForShareRequest($share_id, $secret, $expired): Request
    {
        $attr = [
            'share_id' => $share_id,
            'secret'   => $secret,
            'expired'  => $expired,
        ];
        return new Request('POST', '/v2/ticket', [], json_encode($attr));
    }

    /**
     * @throws Exception
     */
    protected function getForShare($share_id, $secret, $options)
    {
        $ticket_name = $this->request->config['name'] . '_share_ticket';
        $expired     = $options['expired'] ?? 1209600;

        return $this->remember($ticket_name, $expired - 3600, function () use ($share_id, $secret, $expired) {
            $request  = $this->getForShareRequest($share_id, $secret, $expired);
            $response = $this->request->requestJsonSync($request);
            return $response['ticket'];
        });
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getTicket($config, $options = [])
    {
        $type = $config['app_type'];

        switch ($type) {
            case 'enterprise':
                return $this->getForEnterprise($config['application_id'], $config['application_secret'], $options);
            case 'share':
                return $this->getForShare($config['share_id'], $config['secret'], $options);
            default:
                return '';
        }
    }

    public function parse($body = [], $options = [])
    {
        return $this->request->execute('GET', "/ticket/parse", $body, $options);
    }

    /**
     * @throws Exception
     */
    protected function remember($name, $expired, $callback) {

        if(!self::$cache) {
            throw new Exception('not cache params');
        }

        $name = $name.'_'.$this->request->getConfig('application_id');

        $ticket = self::$cache->get($name, false);

        if(!$ticket) {
            self::$cache->set($name, $ticket = $callback(), $expired);
        }

        return $ticket;
    }
}
