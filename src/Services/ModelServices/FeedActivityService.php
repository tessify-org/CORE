<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use App\Models\User;
use Tessify\Core\Models\FeedActivity;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class FeedActivityService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\FeedActivity";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function create($name, $target, User $actor = null, array $data = null, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        return FeedActivity::create([
            "user_id" => $user->id,
            "actor_id" => !is_null($actor) ? $actor->id : null,
            "target_type" => get_class($target),
            "target_id" => $target->id,
            "name" => $name,
            "data" => $data,
        ]);
    }
}