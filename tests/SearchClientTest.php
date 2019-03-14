<?php

namespace HomeSheer\OpenSearch\Test;

use HomeSheer\OpenSearch\Sdk\Builders\SearchParamsBuilder;
use HomeSheer\OpenSearch\Sdk\Builders\Wrappers\OpenSearchResult;
use HomeSheer\OpenSearch\Sdk\Clients\SearchClient;

class SearchClientTest extends OpenSearchClientTest
{
    /**
     * @var SearchClient
     */
    private $searchClient;

    public function setUp(): void
    {
        parent::setUp();
        $this->searchClient = new SearchClient($this->openSearchClient);
    }

    public function testExecute()
    {
        // 实例化一个搜索参数类
        $params = new SearchParamsBuilder();

        //设置config子句的start值
        $params->setStart(0);
        //设置config子句的hit值
        $params->setHits(20);
        // 指定一个应用用于搜索
        $params->setAppName($this->config['app_name']);
        // 指定搜索关键词
        $params->setQuery("name:'搜索'");
        // 指定返回的搜索结果的格式为json
        $params->setFormat("fulljson");
        //添加排序字段
        $params->addSort('RANK', SearchParamsBuilder::SORT_DECREASE);
        // 执行搜索，获取搜索结果
        $result = $this->searchClient->execute($params->build());

        $this->assertInstanceOf(OpenSearchResult::class, $result);
        $result = json_decode($result->result);
        $this->assertEquals('OK', $result->status);
    }

}
