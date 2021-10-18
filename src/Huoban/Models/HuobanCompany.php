<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

/**
 * 伙伴公司接口
 */
class HuobanCompany
{
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    public function getMemberAllRequest($company_id = null, $body = [], $options = [])
    {
        $requests = [];
        // 单次查询最高500条
        $body['limit'] = 1;
        $fir_response  = $this->getMember($company_id, $body, $options);
        // 查询全部数据的所有请求
        for ($i = 0; $i < ceil($fir_response['joined_total'] / $body['limit']); $i++) {
            $requests[] = $this->getMember($company_id, $body, $options + ['res_type' => 'request']);
        }
        return $requests;
    }

    public function getMemberAll($table, $body = [], $options = [])
    {
        $responses = [];
        $requests  = $this->getMemberAllRequest($table, $body, $options);
        // 返回结果集,key为item_id
        $responses = $this->request->requestJsonPool($requests);

        $total          = null;
        $joined_total   = null;
        $unactive_total = null;

        $items = (function () use ($responses, &$joined_total, &$unactive_total, &$total) {
            $items = [];
            foreach ($responses['success_data'] as $success_response) {
                $total          = $total ?: $success_response['response']['total'];
                $joined_total   = $joined_total ?: $success_response['response']['joined_total'];
                $unactive_total = $unactive_total ?: $success_response['response']['unactive_total'];

                foreach ($success_response['response']['members'] as $member) {
                    $items[] = $member;
                }

            }
            return $items;
        })();

        return ['total' => $total, 'joined_total' => $joined_total, 'unactive_total' => $unactive_total, 'members' => $items];
    }

    public function getMemberRequest($company_id, $body = [], $options = [])
    {
        return $this->request->getRequest('POST', "/company_members/company/{$company_id}", $body, $options);
    }
    public function getMember($company_id, $body = [], $options = [])
    {
        return $this->request->execute('POST', "/company_members/company/{$company_id}", $body, $options);
    }
}
