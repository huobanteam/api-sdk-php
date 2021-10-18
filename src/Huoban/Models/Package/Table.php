<?php
/*
 * @Author: SanQian
 * @Date: 2021-09-08 16:22:45
 * @LastEditTime: 2021-09-26 16:24:18
 * @LastEditors: SanQian
 * @Description:
 * @FilePath: /huoban_tools_php/src/Models/Package/Table.php
 *
 */

namespace Huoban\Models\Package;

/**
 * 二次封装伙伴基础模型
 */
trait Table
{
    /**
     * 获取要创建的表结构
     *
     * @param [type] $space_id
     * @param [type] $table_name
     * @param [type] $table_alias
     * @param [type] $maintain_table_alias
     * @param [type] $maintain_fields_items
     * @return void
     */
    public function createTableStructure($space_id, $table_name, $table_alias, $maintain_table_alias, $maintain_fields_items)
    {

        foreach ($maintain_fields_items as $fields_item) {

            $type_id = array_shift($fields_item[$maintain_table_alias . '.app_type_ids']);

            $name  = $fields_item[$maintain_table_alias . '.app_name'];
            $alias = $fields_item[$maintain_table_alias . '.app_en_name'];

            switch ($type_id) {
                case 1: // 文本
                    $fields[] = $this->getFieldTextBasic($name, $alias, $maintain_table_alias, $fields_item);
                    break;
                case 2: // 选项
                    $fields[] = $this->getFieldCategoryBasic($name, $alias, $maintain_table_alias, $fields_item);
                    break;
                case 3: // 数值
                    $fields[] = $this->getFieldNumberBasic($name, $alias);
                    break;
                case 4: // 仅日期
                    $fields[] = $this->getFieldDateBasic($name, $alias);
                    break;
                case 5: // 日期和时间
                    $fields[] = $this->getFieldDateTimeBasic($name, $alias);
                    break;
                case 6: // 关联字段
                    $fields[] = $this->getFieldRelationBasic($name, $alias, $maintain_table_alias, $fields_item);
                    break;
                default:
                    break;
            }
        }

        $body = $this->getTableBasic($space_id, $table_name, $table_alias, $fields);
        return $body;
    }

    /**
     * 获取要更新的表结构
     *
     * @param [type] $table
     * @param [type] $table_name
     * @param [type] $table_alias
     * @param array $update_fields_new
     * @param array $create_fields_new
     * @param array $delete_fields
     * @return void
     */
    public function updateTableStructure($table, $table_name = null, $table_alias = null, $create_fields_new = [], $update_fields_new = [], $delete_fields = [])
    {
        $table_name && $table['name']   = $table_name;
        $table_alias && $table['alias'] = $table_alias;

        foreach ($create_fields_new as $key => $update_field) {
            $create_fields_new[$key]['_new'] = true;
        }

        $table['fields'] = array_merge($update_fields_new, $create_fields_new);

        $new_field_ids             = array_column($create_fields_new, 'field_id');
        $table['new_field_alias']  = $new_field_ids;
        $table['delete_field_ids'] = array_column($delete_fields, 'field_id');

        foreach ($new_field_ids as $new_field_id) {
            $table['list_layout'][]  = $new_field_id;
            $table['field_layout'][] = [$new_field_id];
        }

        return $table;
    }

    /**
     * 返回创建表格的基本格式
     *
     * @param [type] $space_id
     * @param [type] $table_name
     * @param [type] $table_alias
     * @param array $fields
     * @return void
     */
    public function getTableBasic($space_id, $table_name, $table_alias = null, $fields = [])
    {
        $list_layout = array_column($fields, 'field_id');
        foreach ($list_layout as $field_id) {
            $field_layout[] = [$field_id];
        }

        return [
            'name'         => $table_name,
            'alias'        => $table_alias ?: md5(uniqid(microtime(true), true)),
            'item_name'    => '',
            'icon'         => [
                'id'    => 600,
                'color' => 'a',
            ],
            'fields'       => $fields,
            'field_layout' => $field_layout,
            'list_layout'  => $list_layout,
            'space_id'     => $space_id,
            'space'        => [
                'space_id' => $space_id,
            ],
            'field_sync'   => 1,
        ];
    }

    /**
     * 返回创建数值字段的基本格式
     *
     * @param [type] $name
     * @param [type] $alias
     * @return void
     */
    public function getFieldNumberBasic($name, $alias)
    {

        return [
            'field_id'        => $alias,
            'name'            => $name,
            "_name"           => $name,
            'alias'           => $alias ?: md5(uniqid(microtime(true), true)),
            "icon"            => "&#xe656;",
            "type"            => "number",
            "_new"            => true,
            "value"           => [],
            "default_setting" => [
                "type"  => "",
                "value" => "",
            ],
            "_description"    => "用于求和，求平均值等运算",
            "config"          => [
                "display_mode" => "number",
            ],
        ];
    }

    /**
     * 返回创建日期字段的基本格式
     *
     * @param [type] $name
     * @param [type] $alias
     * @return void
     */
    public function getFieldDateBasic($name, $alias)
    {
        return [
            'field_id'        => $alias,
            'name'            => $name,
            'alias'           => $alias ?: md5(uniqid(microtime(true), true)),
            "type"            => "date",
            "_new"            => true,
            "value"           => [],
            "preserved"       => true,
            "icon"            => "&#xe647;",
            "id"              => "rb6huulu",
            "manual"          => true,
            "config"          => [
                "type"                   => "date",
                "show_week_day"          => false,
                "background_color_alias" => "",
            ],
            "required"        => false,
            "default_setting" => [
                "value"    => null,
                "type"     => "",
                "relation" => null,
                "script"   => null,
            ],
            "lock"            => [],
            "locked_rights"   => [],
            "description"     => "",
            "scope"           => null,
        ];
    }

    /**
     * 返回创建日期时间字段的基本格式
     *
     * @param [type] $name
     * @param [type] $alias
     * @return void
     */
    public function getFieldDateTimeBasic($name, $alias)
    {
        return [
            'field_id'        => $alias,
            'name'            => $name,
            'alias'           => $alias ?: md5(uniqid(microtime(true), true)),
            "id"              => $alias,
            "_new"            => true,
            "type"            => "date",
            "icon"            => "&#xe647;",
            "preserved"       => true,
            "manual"          => true,
            "config"          => [
                "type"                   => "datetime",
                "show_week_day"          => false,
                "background_color_alias" => "",
            ],
            "required"        => false,
            "default_setting" => [
                "value"    => null,
                "type"     => "",
                "relation" => null,
                "script"   => null,
            ],
            "lock"            => [],
            "locked_rights"   => [],
            "description"     => "",
            "scope"           => null,
        ];
    }

    /**
     * 返回创建文本字段的基本格式
     *
     * @param [type] $name
     * @param [type] $alias
     * @param string $config_type
     * @return void
     */
    public function getFieldTextBasic($name, $alias, $maintain_table_alias, $fields_item)
    {
        $app_text_type_id = current($fields_item[$maintain_table_alias . '.app_text_type_ids']);

        return [
            'field_id'        => $alias,
            'name'            => $name,
            'alias'           => $alias ?: md5(uniqid(microtime(true), true)),
            'type'            => 'text',
            '_new'            => 1,
            'value'           => [
                [
                    'value' => '',
                ],
            ],
            'preserved'       => 1,
            'icon'            => '&#xe654',
            'manual'          => '1',
            'config'          => [
                'type' => (1 == $app_text_type_id) ? 'input' : 'rich',
            ],
            'default_setting' => [
                'type'  => '',
                'value' => '',
            ],
            'lock'            => [
                'update'      => 0,
                'delete'      => 0,
                'item_update' => 0,
            ],
        ];
    }

    /**
     * 返回创建选项字段的基本格式
     *
     * @param [type] $name
     * @param [type] $alias
     * @param [type] $category_id
     * @param [type] $options
     * @return void
     */
    public function getFieldCategoryBasic($name, $alias, $maintain_table_alias, $fields_item)
    {
        $category_id  = array_shift($fields_item[$maintain_table_alias . '.app_category_ids']);
        $category_arr = json_decode($fields_item[$maintain_table_alias . '.app_category_json'], true);
        $options      = static::getCreateFieldCategoryConfigOptions($category_arr);

        return [
            "field_id"        => $alias,
            "name"            => $name,
            'alias'           => $alias,
            "id"              => $name,
            "_new"            => true,
            "options"         => null,
            "type"            => "category",
            "icon"            => "&#xe903;",
            "preserved"       => true,
            "manual"          => true,
            "config"          => [
                "display_mode"           => "list",
                "type"                   => 1 == $category_id ? "single" : "multi",
                "colorful"               => false,
                "background_color_alias" => "",
                "options"                => $options,
            ],
            "lock"            => [
                "delete"      => 0,
                "update"      => 0,
                "item_update" => 0,
            ],
            "locked_rights"   => [],
            "required"        => false,
            "description"     => "",
            "default_setting" => [
                "value" => [],
            ],
        ];
    }

    /**
     * 返回创建关联字段的基本格式
     *
     * @param [type] $name
     * @param [type] $alias
     * @param [type] $table
     * @return void
     */
    public function getFieldRelationBasic($name, $alias, $maintain_table_alias, $fields_item)
    {
        $app_relation_type_id     = current($fields_item[$maintain_table_alias . '.app_relation_type_ids']);
        $relation_table_id        = $fields_item[$maintain_table_alias . '.app_relation_table_id'];
        $display_attach_field_ids = $fields_item[$maintain_table_alias . '.app_display_attach_field_ids'];
        // 第一个四位数 第二个四位数 第三个四位数 依次代表一级关联，二级关联，三级关联
        //     四位中前两位 11代表创建字段 10代表固有字段
        //     四位中后两位 代表第几个字段被关联

        // 1101 00 0000 00 0000,
        // 1102 00 1101 00 0000,
        // 1102 00 1102 00 0000,
        // 1103 00 0000 00 0000,
        // 1001 00 0000 00 0000

        $table = $this->request->_table->get($relation_table_id);

        return [
            "id"              => $name,
            "field_id"        => $alias,
            "name"            => $name,
            'alias'           => $alias,
            "type"            => "relation",
            "options"         => null,
            "icon"            => "&#xe903;",
            "preserved"       => true,
            "manual"          => true,
            "config"          => [
                'table'                           => $table,
                'table_id'                        => $table['table_id'],
                'type'                            => 1 == $app_relation_type_id ? 'single' : 'multi',
                'display_attach_field_ids'        => $display_attach_field_ids,
                'default_hidden_attach_field_ids' => [],
                'filter'                          => [],
                'recommend_filter'                => [],
                'inner_filter'                    => [],
                'attachable'                      => true,
                'order_by'                        => [],
                'background_color_alias'          => '',
            ],
            "lock"            => [
                "delete"      => 0,
                "update"      => 0,
                "item_update" => 0,
            ],
            "locked_rights"   => [],
            "required"        => false,
            "description"     => "",
            "default_setting" => [
                "value" => [],
            ],
        ];
    }

    /**
     * 根据指定json，创建表格选项字段的数据结构
     *
     * @param [type] $category_options
     * @return void
     */
    public static function getCreateFieldCategoryConfigOptions($category_options)
    {
        foreach ($category_options as $index => $category_option) {
            $options[] = [
                "id"     => $index + 1,
                "name"   => $category_option['name'],
                "status" => $category_option['status'] ?? "active",
                "color"  => $category_option['color'] ?? "h",
            ];
        }

        return $options;
    }
}
