<?php
namespace Huoban\Utils;

use Huoban\Models\HuobanTable;

class TableInfo
{

	/**
    * 获取表字段信息
    * table_info 表格配置信息
    * table_id int 表格id
    * type 数字型 或 字符型(想要转成的类型) 
    * options json '[["space_id", "name", "app_id"]]'; //返回字段设置，只能筛选第一级  
    * @return array
    */
    public static function tableInfo($table_info, $table_id, $type, $num)
    {   
        try {
            $data = [];
            switch ($type) {
                case 'number':
                    if (isset($table_info['table_id'])) {
                        $data .= '\'table_id\' => \''.$table_info['table_id'].'\',// '.$table_info['name'].' <br />';
                    }
                    if(isset($table_info['fields'])){
                        foreach ($table_info['fields'] as $key => $value) {
                           $data .= '\''.$value['field_id'].'\' => \''.$num.'\',//'.$value['name'].' '.$value['type'].'<br />';
                        }
                    } 
                    break;
                default:
                    if (isset($table_info['table_id'])) {
                        $data .= '\'table_id\' => \''.$table_info['table_id'].'\',// '.$table_info['name'].' <br />';
                    }
                    if(isset($table_info['fields'])){
                        foreach ($table_info['fields'] as $key => $value) {
                           $data .= '\'\' => \''.$value['field_id'].'\',//'.$value['name'].' '.$value['type'].'<br />';
                        }
                    }
                    break;
            }
            return $data;
        } catch(HuobanException $e) {
            printf($e->getMessage() . "\n");
        }

    }
    // /**
    // * 获取表字段信息
    // * table_info 表格配置信息
    // * type 数字型 或 字符型(想要转成的类型) 
    // * options json '[["space_id", "name", "app_id"]]'; //返回字段设置，只能筛选第一级  
    // *
    // * @return array
    // */
    // public static function tableInfo($table_info, $type, $num, $options)
    // {
    //     $data = [];
    //     switch ($type) {
    //         case 'number':
    //             if (isset($table_info['table_id'])) {
    //                 $data .= '\'table_id\' => \''.$table_info['table_id'].'\',// '.$table_info['name'].'\\r\\n';
    //             }
    //             if(isset($table_info['fields'])){
    //                 foreach ($table_info['fields'] as $key => $value) {
    //                    $data .= '\''.$value['field_id'].'\' => \''.$num.'\',//'.$value['name'].' '.$value['type'].'\\r\\n';
    //                 }
    //             } 
    //             break;
    //         default:
    //             if (isset($table_info['table_id'])) {
    //                 $data .= '\'table_id\' => \''.$table_info['table_id'].'\',// '.$table_info['name'].'\\r\\n';
    //             }
    //             if(isset($table_info['fields'])){
    //                 foreach ($table_info['fields'] as $key => $value) {
    //                    $data .= '\'\' => \''.$value['field_id'].'\',//'.$value['name'].' '.$value['type'].'\\r\\n';
    //                 }
    //             }
    //             break;
    //     }
    //     return $data;
    // }

}