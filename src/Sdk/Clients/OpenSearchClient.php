<?php

namespace HomeSheer\OpenSearch\Sdk\Clients;

use HomeSheer\OpenSearch\Sdk\Builders\Wrappers\OpenSearchResult;
use HomeSheer\OpenSearch\Sdk\Builders\Wrappers\TraceInfo;

class OpenSearchClient
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PATCH = 'PATCH';

    const API_VERSION = '3';
    const API_TYPE = 'openapi';

    const SDK_VERSION = '3.1.0';
    const SDK_TYPE    = 'opensearch_sdk';

    private $accessKeyId = '';
    private $secret = '';
    private $endPoint = '';
    private $debug = false;
    private $gzip = false;
    public $timeout = 10;
    public $connectTimeout = 1;

    /**
     * OpenSearchClient constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    /**
     * @param array $config
     *
     * @throws \Exception
     */
    public function setConfig(array $config)
    {
        if (!isset($config['access_key_id'])) {
            throw new \Exception('access_key_id can not be blank');
        }

        $this->accessKeyId = trim($config['access_key_id']);

        if (!isset($config['secret'])) {
            throw new \Exception('secret can not be blank');
        }

        $this->secret = $config['secret'];

        if (!isset($config['end_point'])) {
            throw new \Exception('end_point can not be blank');
        }

        $this->endPoint = $config['end_point'];

        if (!is_array($config['options'])) {
            throw new \Exception('options must be array');
        }

        $this->debug = isset($config['options']['debug']) ? boolval($config['options']['debug']): false;
        $this->gzip = isset($config['options']['gzip']) ? boolval($config['options']['gzip']) : false;
        $this->timeout = isset($config['options']['timeout']) ? intval($config['options']['timeout']) : 10;
        $this->connectTimeout = isset($config['options']['connectTimeout']) ? intval($config['options']['connectTimeout']) : 1;
    }

    /**
     * 发送一个GET请求。
     *
     * @param string $uri 发起GET请求的uri。
     * @param array $params 发起GET请求的参数，以param_key => param_value的方式体现。
     *
     * @return OpenSearchResult
     */
    public function get($uri, $params = [])
    {
        return $this->call($uri, $params, '', self::METHOD_GET);
    }

    /**
     * 发送一个PUT请求。
     *
     * @param string $uri 发起PUT请求的uri。
     * @param string $body 发起PUT请求的body体，为一个原始的json格式的string。
     *
     * @return OpenSearchResult
     */
    public function put($uri, $body = '')
    {
        return $this->call($uri, array(), $body, self::METHOD_PUT);
    }

    /**
     * 发送一个POST请求。
     *
     * @param string $uri 发起POST请求的uri。
     * @param string $body 发起POST请求的body体，为一个原始的json格式的string。
     *
     * @return OpenSearchResult
     */
    public function post($uri, $body = '')
    {
        return $this->call($uri, array(), $body, self::METHOD_POST);
    }

    /**
     * 发送一个DELETE请求。
     *
     * @param string $uri 发起DELETE请求的uri。
     * @param string $body 发起DELETE请求的body体，为一个原始的json格式的string。
     *
     * @return OpenSearchResult
     */
    public function delete($uri, $body = '')
    {
        return $this->call($uri, array(), $body, self::METHOD_DELETE);
    }

    /**
     * 发送一个PATCH请求。
     *
     * @param string $uri 发起PATCH请求的uri。
     * @param string $body 发起PATCH请求的body体，为一个原始的json格式的string。
     *
     * @return OpenSearchResult
     */
    public function patch($uri, $body = '')
    {
        return $this->call($uri, array(), $body, self::METHOD_PATCH);
    }

    /**
     * 发送一个请求。
     *
     * @param string $uri 发起请求的uri。
     * @param array $params 指定的url中的query string 列表。
     * @param string $body 发起请求的body体，为一个原始的json格式的string。
     * @param string $method 发起请求的方法，有GET/POST/DELETE/PUT/PATCH等
     *
     * @return OpenSearchResult
     */
    public function call($uri, array $params, $body, $method)
    {
        $path = "/v" . self::API_VERSION . "/" . self::API_TYPE . "{$uri}";
        $url = $this->endPoint . $path;

        $items = [];
        $items['method'] = $method;
        $items['request_path'] = $path;
        $items['content_type'] = "application/json";
        $items['accept_language'] = "zh-cn";
        $items['date'] = gmdate('Y-m-d\TH:i:s\Z');
        $items['opensearch_headers'] = [];
        $items['content_md5'] = "";
        $items['opensearch_headers']['X-Opensearch-Nonce'] = $this->nonce();

        if ($method != self::METHOD_GET) {
            if (!empty($body)) {
                $items['content_md5'] = md5($body);
                $items['body_json'] = $body;
            }
        }
        $items['query_params'] = $params;

        $signature = $this->signature($this->secret, $items);
        $items['authorization'] = "OPENSEARCH {$this->accessKeyId}:{$signature}";

        return $this->curl($url, $items);
    }

    private function nonce()
    {
        return intval(microtime(true) * 1000) . mt_rand(10000, 99999);
    }

    private function signature($secret, $items)
    {
        $params = isset($items['query_params']) ? $items['query_params'] : "";

        $signature = '';
        $string = '';
        $string .= strtoupper($items['method']) . "\n";
        $string .= $items['content_md5'] . "\n";
        $string .= $items['content_type'] . "\n";
        $string .= $items['date'] . "\n";

        $headers = self::filter($items['opensearch_headers']);

        foreach($headers as $key => $value){
            $string .= strtolower($key) . ":" . $value."\n";
        }

        $resource = str_replace('%2F', '/', rawurlencode($items['request_path']));
        $sortParams = self::filter($params);

        $queryString = $this->buildQuery($sortParams);
        $canonicalizedResource = $resource;

        if (!empty($queryString)) {
            $canonicalizedResource .= '?'.$queryString;
        }

        $string .= $canonicalizedResource;

        $signature = base64_encode(hash_hmac('sha1', $string, $secret, true));

        return $signature;
    }

    private function buildQuery($params)
    {
        $query = '';

        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            $query = !empty($params) ? http_build_query($params, null, '&', PHP_QUERY_RFC3986) : '';
        } else {
            $arg = '';
            foreach ($params as $key => $val) {
                $arg .= rawurlencode($key) . "=" . rawurlencode($val) . "&";
            }
            $query = substr($arg, 0, count($arg) - 2);
        }

        return $query;
    }

    private function filter($parameters = [])
    {
        $params = [];

        if (!empty($parameters)) {
            foreach ($parameters as $key => $val) {
                if ($key == "Signature" ||$val === "" || $val === NULL){
                    continue;
                } else {
                    $params[$key] = $parameters[$key];
                }
            }

            uksort($params,'strnatcasecmp');
            reset($params);
        }

        return $params;
    }

    private function getHeaders($items)
    {
        $headers = [];
        $headers[] = 'Content-Type: '.$items['content_type'];
        $headers[] = 'Date: '.$items['date'];
        $headers[] = 'Accept-Language: '.$items['accept_language'];
        $headers[] = 'Content-Md5: '.$items['content_md5'];
        $headers[] = 'Authorization: '.$items['authorization'];

        if (is_array($items['opensearch_headers'])) {
            foreach($items['opensearch_headers'] as $key => $value){
                $headers[] = $key . ": " . $value;
            }
        }

        return $headers;
    }

    private function curl($url, $items)
    {
        $method = strtoupper($items['method']);
        $options = [
            CURLOPT_HTTP_VERSION => 'CURL_HTTP_VERSION_1_1',
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "opensearch/php sdk " . self::SDK_VERSION . "/" . PHP_VERSION,
            CURLOPT_HTTPHEADER => $this->getHeaders($items),
        ];

        if ($method == self::METHOD_GET) {
            $query = $this->buildQuery($items['query_params']);
            $url .= preg_match('/\?/i', $url) ? '&' . $query : '?' . $query;
        } else {
            if (!empty($items['body_json'])) {
                $options[CURLOPT_POSTFIELDS] = $items['body_json'];
            }
        }

        if ($this->gzip) {
            $options[CURLOPT_ENCODING] = 'gzip';
        }

        if ($this->debug) {
            $out = fopen('php://temp','rw');
            $options[CURLOPT_VERBOSE] = true;
            $options[CURLOPT_STDERR] = $out;
        }

        $session = curl_init($url);
        curl_setopt_array($session, $options);
        $response = curl_exec($session);
        curl_close($session);

        $openSearchResult = new OpenSearchResult();
        $openSearchResult->result = $response;

        if ($this->debug) {
            $openSearchResult->traceInfo = $this->getDebugInfo($out, $items);
        }

        return $openSearchResult;
    }

    private function getDebugInfo($handler, $items)
    {
        rewind($handler);
        $trace = new TraceInfo();
        $header = stream_get_contents($handler);
        fclose($handler);

        $trace->tracer = "\n" . $header;

        return $trace;
    }

}
