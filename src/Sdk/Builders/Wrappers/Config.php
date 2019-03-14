<?php

namespace HomeSheer\OpenSearch\Sdk\Builders\Wrappers;

class Config
{
    /**
     * app name 或 app id 或 app version
     *
     * @var string[]
     */
    public $appNames = null;
    /**
     * @var int
     */
    public $start = 0;
    /**
     * @var int
     */
    public $hits = 15;
    /**
     * @var int
     */
    public $searchFormat =   0;
    /**
     * example:  query=config=start:0,hit:15,rerank_size:200,format:json,KVpairs=name:company_name,price:new_price&&query=id:'489013149'</p>
     *
     * config.setCustomConfig(Lists.newArrayList("mykey1:name#company_name,price#new_price"));
     *
     *
     *
     * @var string[]
     */
    public $customConfig = null;
    /**
     * example: cluster=daogou&&kvpairs=name:company_name&&query=笔筒</p>
     *
     * config.setKvpairs("name:company_name,price:new_price");
     *
     *
     *
     * @var string
     */
    public $kvpairs = null;
    /**
     * 获取搜索结果包含的字段列表(fetch_fields)
     *
     *
     * @var string[]
     */
    public $fetchFields = null;
    /**
     * 分区查询.  routeValue为分区键所对应的值.
     *
     *
     * @var string
     */
    public $routeValue = null;

    public function __construct($vals=null)
    {
        if (is_array($vals)) {
            if (isset($vals['appNames'])) {
                $this->appNames = $vals['appNames'];
            }
            if (isset($vals['start'])) {
                $this->start = $vals['start'];
            }
            if (isset($vals['hits'])) {
                $this->hits = $vals['hits'];
            }
            if (isset($vals['searchFormat'])) {
                $this->searchFormat = $vals['searchFormat'];
            }
            if (isset($vals['customConfig'])) {
                $this->customConfig = $vals['customConfig'];
            }
            if (isset($vals['kvpairs'])) {
                $this->kvpairs = $vals['kvpairs'];
            }
            if (isset($vals['fetchFields'])) {
                $this->fetchFields = $vals['fetchFields'];
            }
            if (isset($vals['routeValue'])) {
                $this->routeValue = $vals['routeValue'];
            }
        }
    }

}
