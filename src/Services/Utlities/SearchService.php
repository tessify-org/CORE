<?php

namespace Tessify\Core\Services\Utilities;

use Elasticsearch;

use Users;
use Tasks;
use Projects;
use Ministries;
use Organizations;

use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\Ministry;
use Tessify\Core\Models\Organization;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function search($query)
    {
        $combinedResults = $this->combineResults([
            "user" => $this->searchUsers($query),
            "task" => $this->searchTasks($query),
            "project" => $this->searchProjects($query),
            "ministry" => $this->searchMinistries($query),
            "organization" => $this->searchOrganizations($query),
        ]);
        
        return $combinedResults;
    }

    private function searchUsers($query)
    {
        $model = new User;

        $results = Elasticsearch::search([
            "index" => $model->getSearchIndex(),
            "type" => $model->getSearchType(),
            "body" => [
                "query" => [
                    "multi_match" => [
                        "query" => $query,
                        "fields" => [
                            "first_name",
                            "last_name",
                            "interests",
                            "headline",
                        ],
                        "type" => "best_fields",
                        "tie_breaker" => 0.8
                    ]
                ]
            ]
        ]);

        return $results;
    }

    private function searchProjects($query)
    {
        $model = new Project;

        $results = Elasticsearch::search([
            "index" => $model->getSearchIndex(),
            "type" => $model->getSearchType(),
            "body" => [
                "query" => [
                    "multi_match" => [
                        "query" => $query,
                        "fields" => [

                        ],
                        "type" => "best_fields",
                        "tie_breaker" => 0.8
                    ]
                ]
            ]
        ]);

        return $results;
    }

    private function searchTasks($query)
    {
        $model = new Task;

        $results = Elasticsearch::search([
            "index" => $model->getSearchIndex(),
            "type" => $model->getSearchType(),
            "body" => [
                "query" => [
                    "multi_match" => [
                        "query" => $query,
                        "fields" => [
                            "title",
                            "description",
                        ],
                        "type" => "best_fields",
                        "tie_breaker" => 0.8
                    ]
                ]
            ]
        ]);

        return $results;
    }

    private function searchMinistries($query)
    {
        $model = new Ministry;

        $results = Elasticsearch::search([
            "index" => $model->getSearchIndex(),
            "type" => $model->getSearchType(),
            "body" => [
                "query" => [
                    "multi_match" => [
                        "query" => $query,
                        "fields" => [
                            "name",
                            "abbreviation",
                            "description",
                        ],
                        "type" => "best_fields",
                        "tie_breaker" => 0.8
                    ]
                ]
            ]
        ]);

        return $results;
    }

    private function searchOrganizations($query)
    {
        $model = new Organization;

        $results = Elasticsearch::search([
            "index" => $model->getSearchIndex(),
            "type" => $model->getSearchType(),
            "body" => [
                "query" => [
                    "multi_match" => [
                        "query" => $query,
                        "fields" => [
                            "name",
                            "abbreviation",
                            "description",
                        ],
                        "type" => "best_fields",
                        "tie_breaker" => 0.8
                    ]
                ]
            ]
        ]);

        return $results;
    }

    private function combineResults($results)
    {
        $out = [];

        // Loop through all sets of results
        foreach ($results as $type => $results)
        {   
            // If the results contained hits
            if (count($results["hits"]["hits"]))
            {
                // Loop through all of the hits
                foreach ($results["hits"]["hits"] as $hit)
                {
                    // Grab actual eloquent model instance; using the appropriate model depending on the type
                    $entry = null;
                    switch ($type)
                    {
                        case "user":
                            $entry = Users::find($hit["_id"]);
                            $entry->view_href = route("profile", $entry->slug);
                        break;

                        case "task":
                            $entry = Tasks::find($hit["_id"]);
                            $entry->view_href = route("tasks.view", $entry->slug);
                        break;
                        
                        case "project":
                            $entry = Projects::find($hit["_id"]);
                            $entry->view_href = route("projects.view", $entry->slug);
                        break;
                        
                        case "ministry":
                            $entry = Ministries::find($hit["_id"]);
                            $entry->view_href = "#";
                        break;
                        
                        case "organization":
                            $entry = Organizations::find($hit["_id"]);
                            $entry->view_href = "#";
                        break;
                    }

                    // If we found the entry associated with the hit
                    if (!is_null($entry))
                    {
                        // Add entry to output list
                        $out[] = [
                            "type" => $type,
                            "score" => $hit["_score"],  
                            "entry" => $entry,
                        ];
                    }
                }
            }
        }

        // Convert output to a Collection
        $out = collect($out);
        
        // Return the output sorted by the score (descending, so highest score first and then going down the hill of scoredom..)
        return $out->sortByDesc("score")->values();
    }
}