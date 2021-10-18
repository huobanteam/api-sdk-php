<?php

namespace Huoban\Models\Package;

/**
 * 二次封装伙伴数据基础模型
 */
trait Item
{
    /**
     * 根据item_id，返回对应的格式化数据
     *
     * @param [type] $item_id
     * @return array
     */
    public function getFormatItem($item_id)
    {
        $item = $this->get($item_id);
        return $this->returnDiy($item);
    }
    /**
     * 更新数据并返回格式化的数据信息
     *
     * @param [type] $item_id
     * @param [type] $body
     * @return void
     */
    public function updateAfterFormatItem($item_id, $body)
    {
        $item = $this->updateItem($item_id, $body);
        return $this->returnDiy($item);
    }
}
