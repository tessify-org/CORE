<?php

namespace Tessify\Core\Services\Utilities;

use Elasticsearch;

use Tessify\Core\Models\Project;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function search($query)
    {
        $model = new Project;

        $items = Elasticsearch::search([
            "index" => $model->getSearchIndex(),
            "type" => $model->getSearchType(),
            "body" => [
                "query" => [
                    "multi_match" => [
                        "query" => $query,
                        "fields" => ["title", "description"],
                        "type" => "best_fields",
                        "tie_breaker" => 0.8
                    ]
                ]
            ]
        ]);
        
        return $this->buildCollection($items);
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items["hits"]["hits"], "_id");

        $collection = Project::findMany($ids)->sortBy(function($article) use ($ids) {
            return array_search($article->getKey(), $ids);
        });

        return $collection->values();
    }
}