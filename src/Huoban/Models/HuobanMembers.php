<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;

class HuobanMembers
{
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * 获取工作区成员信息
     *
     * @param [type] $space_id
     * @param array $body
     * @return void
     */
    public function getMembersRequest($space_id, $body = [])
    {
        return $this->request->getRequest('GET', "/space/{$space_id}/members", $body);
    }
    public function getMembers($space_id, $body = [])
    {
        return $this->request->execute('GET', "/space/{$space_id}/members", $body);
    }

    public function getCompanyMembersRequest($company_id, $body = [])
    {
        return $this->request->getRequest('GET', "/company_members/company/{$company_id}", $body);
    }
    public function getCompanyMembers($company_id, $body = [])
    {
        return $this->request->execute('GET', "/company_members/company/{$company_id}", $body);
    }

    public function getMembersGroupsRequest($space_id, $body = [])
    {
        return $this->request->getRequest('GET', "/members_and_groups/space/{$space_id}", $body);
    }
    public function getMembersGroups($space_id, $body = [])
    {
        return $this->request->execute('GET', "/members_and_groups/space/{$space_id}", $body);
    }
}
