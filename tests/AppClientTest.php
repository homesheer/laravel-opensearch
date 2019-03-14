<?php

namespace HomeSheer\OpenSearch\Test;

use HomeSheer\OpenSearch\Sdk\Builders\Wrappers\OpenSearchResult;
use HomeSheer\OpenSearch\Sdk\Builders\Wrappers\Pageable;
use HomeSheer\OpenSearch\Sdk\Clients\AppClient;

class AppClientTest extends OpenSearchClientTest
{
    /**
     * @var AppClient
     */
    private $appClient;

    public function setUp(): void
    {
        parent::setUp();
        $this->appClient = new AppClient($this->openSearchClient);
    }

    public function testSave()
    {
        $result = $this->appClient->save('new_version');

        $this->assertInstanceOf(OpenSearchResult::class, $result);

        $result = json_decode($result->result);

        $this->assertEquals('OK', $result->status);

    }

    public function testGetById()
    {
        $result = $this->appClient->getById($this->config['app_name']);
        $this->assertInstanceOf(OpenSearchResult::class, $result);
        $result = json_decode($result->result);
        $this->assertEquals('OK', $result->status);
    }

    public function testListAll()
    {
        $pageable = new Pageable([
            'page' => 1,
            'size' => 10,
        ]);

        $result = $this->appClient->listAll($pageable);
        $this->assertInstanceOf(OpenSearchResult::class, $result);
        $result = json_decode($result->result);
        $this->assertEquals('OK', $result->status);
    }

}
