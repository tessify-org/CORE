<?php

namespace Tessify\Core\Services\ModelServices;

use DB;
use Auth;
use App\Models\User;
use Tessify\Core\Models\Tag;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class TagService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;

    private $taggables;

    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Tag";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getTaggables()
    {
        if (is_null($this->taggables))
        {
            $this->taggables = DB::table("taggables")->get();
        }

        return $this->taggables;
    }
    
    public function getAllForTask(Task $task)
    {
        $out = [];

        foreach ($this->getTaggables() as $taggable)
        {
            if ($taggable->taggable_type == Task::class && $taggable->taggable_id == $task->id)
            {
                $out[] = $this->find($taggable->tag_id);
            }
        }

        return $out;
    }

    public function getAllForProject(Project $project)
    {
        $out = [];

        foreach ($this->getTaggables() as $taggable)
        {
            if ($taggable->taggable_type == Project::class && $taggable->taggable_id == $project->id)
            {
                $out[] = $this->find($taggable->tag_id);
            }
        }

        return $out;
    }

    public function findOrCreateByName($name)
    {
        foreach ($this->getAll() as $tag)
        {
            if ($tag->name == $name)
            {
                return $tag;
            }
        }

        return Tag::create(["name" => $name]);
    }
}