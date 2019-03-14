<?php

namespace HomeSheer\OpenSearch\Scout;

use HomeSheer\OpenSearch\Sdk\Builders\SearchParamsBuilder;
use HomeSheer\OpenSearch\Sdk\Clients\DocumentClient;
use HomeSheer\OpenSearch\Sdk\Clients\OpenSearchClient;
use HomeSheer\OpenSearch\Sdk\Clients\SearchClient;
use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;

class OpenSearchEngine extends Engine
{
    private const FAIL = 'FAIL';

    private const ERROR_PREFIX = 'OpenSearch: ';

    private $config;

    private $openSearchClient;

    private $documentClient;

    private $searchClient;

    /**
     * OpenSearchEngine constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->config = config('open_search');
        $this->openSearchClient = new OpenSearchClient($this->config);
    }

    /**
     * Update the given model in the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $models
     * @return void
     */
    public function update($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $appName = $this->config['app_name'];
        $tableName = $models->first()->searchableAs();

        $docs = $models->map(function ($model) {
            $fields = $model->toSearchableArray();

            if (empty($fields)) {
                return;
            }

            $doc = [
                'cmd'    => 'UPDATE',
                'fields' => $fields,
            ];

            return $doc;
        })->filter()->values()->all();

        $docs = json_encode($docs);

        if (!empty($docs)) {
            $documentClient = $this->getDocumentClient();
            $result = $documentClient->push($docs, $appName, $tableName);
            $this->checkResult($result);
        }
    }

    /**
     * Remove the given model from the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $models
     * @return void
     */
    public function delete($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $appName = $this->config['app_name'];
        $tableName = $models->first()->searchableAs();

        $docs = $models->map(function ($model) {
            return [
                'cmd' => 'DELETE',
                'fields' => [
                    $model->getKeyName() => $model->getKey(),
                ]
            ];
        })->values()->all();

        $docsJson = json_encode($docs);

        if (!empty($docsJson)) {
            $documentClient = $this->getDocumentClient();
            $documentClient->push($docsJson, $appName, $tableName);
        }
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @return mixed
     */
    public function search(Builder $builder)
    {
        return $this->performSearch($builder, array_filter([
            'filter' => $this->filter($builder),
            'hits' => $builder->limit,
        ]));
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  int  $perPage
     * @param  int  $page
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        return $this->performSearch($builder, [
            'filter' => $this->filter($builder),
            'hits' => $perPage,
            'start' => $page - 1,
        ]);
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  array  $options
     * @return mixed
     */
    protected function performSearch(Builder $builder, array $options = [])
    {
        $params = new SearchParamsBuilder();
        $params->setAppName($this->config['app_name']);
        $params->setFormat('fulljson');
        $params->setQuery($builder->query);

        foreach ($options as $key => $value) {
            switch ($key) {
                case 'filter':
                    foreach ($value as $filter) {
                        $params->addFilter($filter);
                    }

                    break;

                case 'hits':
                    $params->setHits($value);
                    break;

                case 'start':
                    $params->setStart($value);
                    break;
            }
        }

        $searchClient = $this->getSearchClient();
        $result = $searchClient->execute($params->build());

        $this->checkResult($result);

        return $result;
    }

    /**
     * Get the filter array for the query.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @return array
     */
    protected function filter(Builder $builder)
    {
        return collect($builder->wheres)->map(function ($value, $key) {
            return $key.'='.$value;
        })->values()->all();
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed  $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {
        $results = json_decode($results->result);
        $items = $results->result->items;
        $objectIds = [];

        foreach ($items as $item) {
            $objectIds[] = $item->fields->id;
        }

        return $objectIds;
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  mixed  $results
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function map(Builder $builder, $results, $model)
    {
        $results = json_decode($results->result);

        if ($results->result->num === 0) {
            return $model->newCollection();
        }

        $items = $results->result->items;
        $objectIds = [];

        foreach ($items as $item) {
            $objectIds[] = $item->fields->id;
        }

        return $model->getScoutModelsByIds(
            $builder, $objectIds
        )->filter(function ($model) use ($objectIds) {
            return in_array($model->getScoutKey(), $objectIds);
        });
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed  $results
     * @return int
     */
    public function getTotalCount($results)
    {
        $results = json_decode($results->result);

        return $results->result->total;
    }

    /**
     * Flush all of the model's records from the engine.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function flush($model)
    {
        throw new \Exception(sprintf('Version %s OpenSearch SDK does not support flush operation', OpenSearchClient::SDK_VERSION));
    }

    private function getSearchClient()
    {
        if ($this->searchClient) {
            return $this->searchClient;
        }

        $this->searchClient = new SearchClient($this->openSearchClient);

        return $this->searchClient;
    }

    private function getDocumentClient()
    {
        if ($this->documentClient) {
            return $this->documentClient;
        }

        $this->documentClient = new DocumentClient($this->openSearchClient);

        return $this->documentClient;
    }

    private function checkResult($result)
    {
        $originalResult = $result;
        $result = json_decode($result->result);

        if ($result->status == self::FAIL) {
            $error = $result->errors[0];

            throw new \Exception(
                self::ERROR_PREFIX . $error->message . PHP_EOL . 'orignal result: ' . $originalResult->result . PHP_EOL . 'traceInfo: ' . $originalResult->traceInfo,
                $error->code
            );
        }
    }

}
