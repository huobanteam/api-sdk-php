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

use GuzzleHttp\Psr7\Request;

class HuobanTicket
{
    public $request;
    public function __construct($huoban)
    {
        $this->request = $request;
    }

    /**
     * 获取企业授权的请求
     *
     * @param [type] $application_id
     * @param [type] $application_secret
     * @param [type] $expired
     * @return void
     */
    public function getForEnterpriseRequest($application_id, $application_secret, $expired)
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
     * @param [type] $application_id
     * @param [type] $application_secret
     * @param array $options
     * @return void
     */
    public function getForEnterprise($application_id, $application_secret, $options = [])
    {
        $ticket_name = $this->request->config['name'] . '_enterprise_ticket';
        $expired     = $options['expired'] ?? 1209600;

        $ticket = $this->request->_cache->remember($ticket_name, $expired - 3600, function () use ($application_id, $application_secret, $expired) {
            $request  = $this->getForEnterpriseRequest($application_id, $application_secret, $expired);
            $response = $this->request->requestJsonSync($request);
            return $response['ticket'];
        });
        return $ticket;
    }

    /**
     * 获取分享授权的请求
     *
     * @param [type] $share_id
     * @param [type] $secret
     * @param [type] $expired
     * @return void
     */
    public function getForShareRequest($share_id, $secret, $expired)
    {
        $attr = [
            'share_id' => $share_id,
            'secret'   => $secret,
            'expired'  => $expired,
        ];
        return new Request('POST', '/v2/ticket', [], json_encode($attr));
    }
    /**
     * 获取分享授权的执行操作
     *
     * @param [type] $share_id
     * @param [type] $secret
     * @param [type] $options
     * @return void
     */
    public function getForShare($share_id, $secret, $options)
    {
        $ticket_name = $this->request->config['name'] . '_share_ticket';
        $expired     = $options['expired'] ?? 1209600;

        $ticket = $this->request->catch->remember($ticket_name, $expired - 3600, function () use ($share_id, $secret, $expired) {
            $request  = $this->getForShareRequest($share_id, $secret, $expired);
            $response = $this->request->requestJsonSync($request);
            return $response['ticket'];
        });

        return $ticket;
    }

    /**
     * 获取表格授权
     *
     * @return void
     */
    public function getForTable()
    {
        return $_GET['ticket'];
    }

    public function getTicket($config, $options = [])
    {
        $app_type = $config['app_type'] ?? 'table';

        switch ($app_type) {
            case 'table':
                $ticket = $this->getForTable();
                break;
            case 'enterprise':
                $ticket = $this->getForEnterprise($config['application_id'], $config['application_secret'], $options);
                break;
            case 'share':
                $ticket = $this->getForShare($config['share_id'], $config['secret'], $options);
                break;
            default:
                break;
        }
        return $ticket;
    }

    public function parse($body = [], $options = [])
    {
        return $this->request->execute('GET', "/ticket/parse", $body, $options);
    }
}
