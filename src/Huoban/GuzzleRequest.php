<?php


namespace Huoban;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Huoban\Models\HuobanTicket;

class GuzzleRequest implements RequestInterface
{
    /**
     * 文件基础配置
     *
     * @var array
     */
    public $config;

    protected $client;

    /**
     * 初始化配置信息
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function setConfig($key, $val) {
        $this->config[$key] = $val;
    }

    public function getConfig($key, $val = '') {
        return $this->config[$key] ?? $val;
    }

    /**
     * 执行具体操作
     *
     * @param string $method
     * @param string $url
     * @param array $body
     * @param array $options
     * @return void
     */
    public function execute($method, $url, $body = [], $options = [])
    {
        $request = $this->getRequest($method, $url, $body, $options);
        // 普通接口请求('api')，上传请求('upload')，bi请求('bi')，
        $interface_type = $options['interface_type'] ?? 'api';

        return $this->requestJsonSync($request, $interface_type);
    }
    /**
     * 获取执行工作的请求
     *
     * @param string $method
     * @param string $url
     * @param array $body
     * @param array $options
     * @return \GuzzleHttp\Psr7\Request
     */
    public function getRequest($method, $url, $body = [], $options = [])
    {
        $url     = $options['version'] ?? '/v2' . $url;
        $body    = json_encode($body);
        $headers = $this->defaultHeader($options);

        return new Request($method, $url, $headers, $body);
    }
    /**
     * 设置请求的默认请求头
     *
     * @param array $options
     * @return array
     */
    public function defaultHeader($options = [])
    {
        $default_headers = [
            'Content-Type'                   => 'application/json',
        ];

        if(isset($this->config['space_id'])) {
            $default_headers['X-Huoban-Return-Alias-Space-Id'] = $this->config['space_id'];
        }

        if(isset($this->config['ticket'])) {
            $default_headers['X-Huoban-Ticket'] = $this->config['ticket'];
        }

        return array_merge($default_headers, $options);
    }
    /**
     * 发送请求，并返回结果
     *
     * @param \GuzzleHttp\Psr7\Request $request
     * @param string $interface_type
     * @return void
     */
    public function requestJsonSync(\GuzzleHttp\Psr7\Request $request, $interface_type = 'api')
    {
        try {
            $response = $this->getHttpClient($interface_type)->send($request);
        } catch (ServerException $e) {
            $response = $e->getResponse();
        }

        return json_decode($response->getBody(), true);
    }
    /**
     * 批量发送请求，并返回结果
     *
     * @param \GuzzleHttp\Psr7\Request $requests
     * @param string $interface_type
     * @param integer $concurrency
     * @return array
     */
    public function requestJsonPool($requests, $interface_type = 'api', $concurrency = 20)
    {

        $success_data = $error_data = [];
        $client       = $this->getHttpClient($interface_type);

        $pool = new Pool($client, $requests, [
            'concurrency' => $concurrency,
            'fulfilled'   => function ($response, $index) use (&$success_data) {
                $success_data[] = [
                    'index'    => $index,
                    'response' => json_decode($response->getBody(), true),
                ];
            },
            'rejected'    => function ($response, $index) use (&$error_data) {
                $error_data[] = [
                    'index'    => $index,
                    'response' => $response,
                ];
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
        return ['success_data' => $success_data, 'error_data' => $error_data];
    }
    /**
     * 获取请求客户端
     *
     * @param string $interface_type
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient($interface_type)
    {
        return $this->client[$interface_type] = new Client([
            'base_uri'    => $this->config['urls'][$interface_type],
            'timeout'     => 600,
            'verify'      => false,
            'http_errors' => false,
            'headers'     => $this->defaultHeader(),
        ]);
    }
}