<?php

namespace HomeSheer\OpenSearch\Sdk\Clients;

use HomeSheer\OpenSearch\Sdk\Builders\UrlParamsBuilder;

class SearchClient
{
    private const SEARCH_API_PATH = '/apps/%s/search';

    /**
     * @var OpenSearchClient
     */
    private $openSearchClient;

    /**
     * SearchClient constructor.
     *
     * @param OpenSearchClient $openSearchClient
     */
    public function __construct($openSearchClient)
    {
        $this->openSearchClient = $openSearchClient;
    }

    public function execute($searchParams)
    {
        $path = $this->getPath($searchParams);
        $builder = new UrlParamsBuilder($searchParams);

        return $this->openSearchClient->get($path, $builder->getHttpParams());
    }

    private function getPath($searchParams)
    {
        $appNames = isset($searchParams->config->appNames) ? implode(',', $searchParams->config->appNames) : '';

        return sprintf(self::SEARCH_API_PATH, $appNames);
    }

}
