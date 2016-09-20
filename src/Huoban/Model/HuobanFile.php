<?php
/**
 * HuobanFile
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanFile {

    public static function upload($file_path, $file_name, $type = 'attachment') {

        return HuobanClient::post('/file', array('source' => realpath($file_path), 'name' => $file_name, 'type' => $type), array('upload' => TRUE));
    }
}
