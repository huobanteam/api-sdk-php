<?php
/*
 * @Author: ZhaohangYang <yangzhaohang@comsenz-service.com>
 * @Date: 2021-01-20 16:17:35
 * @Description: 伙伴智慧大客户研发部
 */

namespace App\Config;

class HuobanConfig
{
    /**
     * 伙伴基础类，配置信息
     *
     * @return array
     */
    public static function getHuobanConfig()
    {
        return [
            // 伙伴类型，enterprise，table，share
            'app_type'           => 'enterprise',
            // 接口api地址
            'api_url'            => defined('TEST') && constant('TEST') == true ? 'https://api-dev.huoban.com' : 'https://api.huoban.com',
            // 上传文件地址
            'upload_url'         => defined('TEST') && constant('TEST') == true ? 'https://upload.huoban.com' : 'https://upload.huoban.com',
            // 企业api 授权
            'application_id'     => '',
            'application_secret' => '',
            // 别名服务是否开启
            'alias_model'        => true,
            // 工作区id
            'space_id'           => '',
            // 二次验证所必须
            'security_auth'      => false,
            'password'           => '',
            // 企业id
            'company_ids'        => [],
        ];
    }
}
