<?php
/**
 * Huoban
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class Huoban {

    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_PUT = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';

    static $ticket, $url, $ch, $headers;

    public static function setup($ticket, $is_test = true) {

        self::$ticket = $ticket;

        self::$url = $is_test ? 'http://api.dev.huoban.com' : 'https://api.huoban.com';

        self::$headers = array(
            'Accept' => 'application/json',
            'Cookie' => 'hb_dev_host=dev',
        );

        self::$ch = curl_init();
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(self::$ch, CURLOPT_HEADER, true);
        curl_setopt(self::$ch, CURLINFO_HEADER_OUT, true);
    }

    public static function request($method, $url, $attributes = array(), $options = array()) {

        if (!self::$ch) {
            throw new Exception('Huoban Client has not been setup with client id and client secret.');
        }

        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, null);

        $encoded_attributes = array();
        $headers = array();

        $version = isset($options['version']) ? $options['version'] : 'v2';
        $url = "/$version$url";

        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, $method);
        switch ($method) {
            case self::HTTP_METHOD_GET:
                self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
                if ($attributes) {
                    $query = self::encode_attributes($attributes);
                    $url = $url . '?' . $query;
                }
                break;
            case self::HTTP_METHOD_DELETE:
                self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
                if ($attributes) {
                    $query = self::encode_attributes($attributes);
                    $url = $url . '?' . $query;
                }
                break;
            case self::HTTP_METHOD_POST:
                if (isset($options['upload']) && $options['upload']) {
                    self::$headers['Content-type'] = 'multipart/form-data';

                    // php5.6之后的只能使用这个方法
                    $file = curl_file_create($attributes['source'], '', $attributes['name']);

                    $attributes['source'] = $file;
                    curl_setopt(self::$ch, CURLOPT_POST, TRUE);
                    curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $attributes);
                } else {
                    self::$headers['Content-type'] = 'application/json';

                    curl_setopt(self::$ch, CURLOPT_POST, TRUE);
                    $encoded_attributes = json_encode($attributes);
                    curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
                }
                break;
            case self::HTTP_METHOD_PUT:
                $encoded_attributes = json_encode($attributes);
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
                self::$headers['Content-type'] = 'application/json';
                break;
        }

        if (self::$ticket) {
            self::$headers['X-Huoban-Ticket'] = self::$ticket;
        }

        if (isset($options['headers']) && $options['headers']) {
            foreach ($options['headers'] as $key => $value) {
                self::$headers[$key] = $value;
            }
        }

        if (isset($options['fields'])) {
            self::$headers['X-Huoban-Return-Fields'] = json_encode($options['fields']);
        }

        curl_setopt(self::$ch, CURLOPT_HTTPHEADER, self::curl_headers(self::$headers));

        if (substr($url, 0, 4) == 'http') {
            $request_url = $url;
        } else {
            $request_url = self::$url . $url;
        }
        curl_setopt(self::$ch, CURLOPT_URL, $request_url);

        $raw_response = curl_exec(self::$ch);
        $raw_headers_size = curl_getinfo(self::$ch, CURLINFO_HEADER_SIZE);
        $status = curl_getinfo(self::$ch, CURLINFO_HTTP_CODE);

        $response_content = substr($raw_response, $raw_headers_size);
        if ($response_content === false) {
            $response_content = '';
        }

        $response_headers = substr($raw_response, 0, $raw_headers_size);
        $response_headers = self::parse_headers($response_headers);

        $body = json_decode($response_content, true);
        if ($status == 500) {
            throw new HuobanException($body['message'], $body['code']);
        } elseif ($status == 200) {
            return $body;
        } else {
            throw new HuobanException('unknow response', $status);
        }
    }

    public static function get($url, $attributes = array(), $options = array()) {
        return self::request(self::HTTP_METHOD_GET, $url, $attributes, $options);
    }

    public static function post($url, $attributes = array(), $options = array()) {
        return self::request(self::HTTP_METHOD_POST, $url, $attributes, $options);
    }

    public static function put($url, $attributes = array(), $options = array()) {
        return self::request(self::HTTP_METHOD_PUT, $url, $attributes, $options);
    }

    public static function delete($url, $attributes = array()) {
        return self::request(self::HTTP_METHOD_DELETE, $url, $attributes);
    }

    public static function encode_attributes($attributes) {

        $result = '';
        if (is_array($attributes)) {
            $result = http_build_query($attributes, '', '&');
        }

        return $result;
    }

    public static function curl_headers($curl_headers) {
        $headers = array();
        foreach ($curl_headers as $header => $value) {
            $headers[] = "{$header}: {$value}";
        }
        return $headers;
    }

    public static function parse_headers($headers) {
        $list = array();
        $headers = str_replace("\r", '', $headers);
        $headers = explode("\n", $headers);
        foreach ($headers as $header) {
            if (strstr($header, ':')) {
                $name = strtolower(substr($header, 0, strpos($header, ':')));
                $list[$name] = trim(substr($header, strpos($header, ':')+1));
            }
        }
        return $list;
    }
}
