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
            $array = $model->toSearchableArray();

            if (empty($array)) {
                return;
            }

            $array['cmd'] = 'UPDATE';

            return $array;
        })->filter()->values()->all();

        $docsJson = json_encode($docs);

        if (!empty($docsJson)) {
            $documentClient = $this->getDocumentClient();
            $documentClient->push($docsJson, $appName, $tableName);
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
            'numericFilters' => $this->filters($builder),
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
            'numericFilters' => $this->filters($builder),
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

        $searchClient = $this->getSearchClient();

        $searchClient->execute($params);
    }

    /**
     * Get the filter array for the query.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @return array
     */
    protected function filters(Builder $builder)
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

    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed  $results
     * @return int
     */
    public function getTotalCount($results)
    {

    }

    /**
     * Flush all of the model's records from the engine.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function flush($model)
    {

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

}
