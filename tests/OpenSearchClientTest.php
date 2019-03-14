<?php

namespace HomeSheer\OpenSearch\Test;

use HomeSheer\OpenSearch\Sdk\Clients\OpenSearchClient;
use PHPUnit\Framework\TestCase;

class OpenSearchClientTest extends TestCase
{
    protected $config;

    protected $openSearchClient;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->config = require_once('./../src/config/open_search.php');

        $this->openSearchClient = new OpenSearchClient($this->config);
    }

}
