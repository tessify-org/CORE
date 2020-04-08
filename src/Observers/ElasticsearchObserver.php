<?php

namespace Tessify\Core\Observers;

use Elasticsearch;

class ElasticsearchObserver
{
    public function saved($instance)
    {
        Elasticsearch::index([
            "index" => $instance->getSearchIndex(),
            "type" => $instance->getSearchType(),
            "id" => $instance->getKey(),
            "body" => $instance->toSearchArray(),
        ]);
    }

    public function deleted($instance)
    {   
        Elasticsearch::delete([
            "index" => $instance->getSearchIndex(),
            "type" => $instance->getSearchType(),
            "id" => $instance->getKey(),
        ]);
    }
}