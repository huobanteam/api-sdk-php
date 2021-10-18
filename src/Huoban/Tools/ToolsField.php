<?php

namespace Huoban\Tools;

class ToolsField
{
    public static function getCreateFieldTextValue()
    {
        return [
            [
                'value' => '',
            ],
        ];
    }

    public static function getCreateFieldTextConfig()
    {
        return [
            'type' => 'input',
        ];
    }

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
