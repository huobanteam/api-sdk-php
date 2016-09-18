<?php
/**
 * HuobanFile
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanFile {

    public static function upload($file_path, $file_name, $type = 'attachment') {

        return Huoban::post('/file', array('source' => realpath($file_path), 'name' => $file_name, 'type' => $type), array('upload' => TRUE));
    }
}
