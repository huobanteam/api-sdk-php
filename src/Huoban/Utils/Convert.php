<?php
namespace Huoban\Utils;

class Convert
{
    /**
     *批量数据转换
     */
    public static function convertMultitemFields($table_info, $items_info)
    {
        $data = array();
        if (!isset($items_info['filtered'])) {
            return $data;
        }

        $data['filtered'] = $items_info['filtered'];
        $data['total']    = $items_info['total'];
        $temp             = array();
        foreach ($items_info['items'] as $key => $item) {
            $temp[] = self::convertItemFields($table_info, $item);
        }
        $data['data'] = $temp;
        return $data;
    }
    /**
     *单条数据转换
     */
    public static function convertItemFields($table_info, $item)
    {
        $data = array();
        if (!empty($table_info)) {
            $item_info          = self::fieldsConvert($item['fields']); //转换fields
            $data['item_id']    = $item['item_id'];
            $data['created_on'] = $item['created_on'];
            $data['updated_on'] = isset($item['updated_on']) ? $item['updated_on'] : '';
            foreach ($table_info as $key => $field_id) {
                if (empty($key)) {
                    continue;
                }
                if (isset($item_info[$field_id])) {
                    $data[$key] = self::fieldInfo($item_info[$field_id]);
                } else {
                    $data[$key] = '';
                    if ($key == 'table_id') {
                        $data['table_id'] = $field_id;
                    }
                }
            }
        }
        return $data;
    }
    /**
     * 获取表格设置字段值，包含空值
     * @param  $implode_str 数组值组合字符串
     */
    public static function getSetFieldValue($table_info, $fields_info, $implode_str = null)
    {
        $data = [];
        if (!empty($fields_info)) {
            $table_info_flip = array_flip($table_info);
            foreach ($fields_info as $info_key => $info_value) {
                $key_name = isset($table_info_flip[$info_value['field_id']]) ? $table_info_flip[$info_value['field_id']] : '';
                switch ($info_value['type']) {
                    case 'text':
                        $data[$key_name] = $info_value['values'][0]['display_value'];
                        break;
                    case 'number':
                        $data[$key_name] = $info_value['values'][0]['value'];
                        break;
                    case 'calculation':
                        $data[$key_name] = $info_value['values'][0]['value'];
                        break;
                    case 'relation':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = [
                                'id'    => $value['item_id'],
                                'title' => $value['title'],
                            ];
                        }
                        $data[$key_name] = $temp;
                        break;
                    case 'category':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = [
                                'id'   => $value['id'],
                                'name' => $value['name'],
                            ];
                        }
                        $data[$key_name] = $temp;
                        break;
                    case 'user':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value;
                        }
                        $data[$key_name] = $temp;
                        break;
                    case 'date':
                        $key             = $info_value['field_id'];
                        $data[$key_name] = $info_value['values'][0]['value'];
                        break;
                    case 'image':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value['name'];
                        }
                        if ($implode_str !== null) {
                            $data[$key_name] = implode($implode_str, $temp);
                        } else {
                            $data[$key_name] = $temp;
                        }
                        break;
                    case 'file':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value['name'];
                        }
                        if ($implode_str !== null) {
                            $data[$key_name] = implode($implode_str, $temp);
                        } else {
                            $data[$key_name] = $temp;
                        }
                        break;
                    case 'location':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value['value']['address'];
                        }
                        if ($implode_str !== null) {
                            $data[$key_name] = implode($implode_str, $temp);
                        } else {
                            $data[$key_name] = $temp;
                        }
                        break;
                    default:
                        break;
                }
            }
            foreach ($table_info_flip as $table_key => $table_value) {
                if (!isset($data[$table_value])) {
                    $data[$table_value] = '';
                }
            }
        }
        return $data;
    }
    /**
     * 获取字段值,不包含空值
     * @param  $implode_str 数组值组合字符串
     */
    public static function getFieldValue($fields_info, $implode_str = null)
    {
        $data = [];
        if (!empty($fields_info)) {
            foreach ($fields_info as $info_key => $info_value) {
                switch ($info_value['type']) {
                    case 'text':
                        $data[$info_value['field_id']] = $info_value['values'][0]['display_value'];
                        break;
                    case 'number':
                        $data[$info_value['field_id']] = $info_value['values'][0]['value'];
                        break;
                    case 'calculation':
                        $data[$info_value['field_id']] = $info_value['values'][0]['value'];
                        break;
                    case 'relation':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value['title'];
                        }
                        $data[$info_value['field_id']] = implode(';', $temp);
                        break;
                    case 'category':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value;
                        }
                        $data[$info_value['field_id']] = $temp;
                        break;
                    case 'user':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value;
                        }
                        $data[$info_value['field_id']] = $temp;
                        break;
                    case 'date':
                        $key                           = $info_value['field_id'];
                        $data[$info_value['field_id']] = $info_value['values'][0]['value'];
                        break;
                    case 'image':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value['name'];
                        }
                        if ($implode_str !== null) {
                            $data[$info_value['field_id']] = implode($implode_str, $temp);
                        } else {
                            $data[$info_value['field_id']] = $temp;
                        }
                        break;
                    case 'file':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value['name'];
                        }
                        if ($implode_str !== null) {
                            $data[$info_value['field_id']] = implode($implode_str, $temp);
                        } else {
                            $data[$info_value['field_id']] = $temp;
                        }
                        break;
                    case 'location':
                        $temp = [];
                        foreach ($info_value['values'] as $key => $value) {
                            $temp[] = $value['value']['address'];
                        }
                        if ($implode_str !== null) {
                            $data[$info_value['field_id']] = implode($implode_str, $temp);
                        } else {
                            $data[$info_value['field_id']] = $temp;
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        return $data;
    }

    public static function fieldsConvert($fields_info, $type = 'field_id')
    {
        $data = array();
        foreach ($fields_info as $key => $value) {
            if ($type == 'alias') {
                $data[$value['alias']] = $value;
            } else {
                $data[$value['field_id']] = $value; 
            }
        }
        return $data;
    }

    private static function fieldInfo($field)
    {
        if (empty($field)) {
            return '';
        }
        $type = $field['type'];
        $data = array();
        switch ($type) {
            case 'relation':
                foreach ($field['values'] as $key => $value) {
                    $data[] = $value;
                }
                break;
            case 'image':
                foreach ($field['values'] as $key => $value) {
                    $data[] = $value;
                }
                break;
            case 'file':
                foreach ($field['values'] as $key => $value) {
                    $data[] = $value;
                }
                break;
            case 'user':
                foreach ($field['values'] as $key => $value) {
                    $data[] = $value;
                }
                break;
            case 'category':
                foreach ($field['values'] as $key => $value) {
                    $data[] = $value;
                }
                break;
            default:
                $data = $field['values'][0];
                break;
        }
        return $data;
    }

}
