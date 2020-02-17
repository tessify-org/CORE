<?php

namespace Tessify\Core\Services\ModelServices;

use Users;

use Tessify\Core\Models\TeamMember;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class TeamMemberService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TeamMember";
    }

    public function preload($instance)
    {
        $instance->user = Users::findPreloaded($instance->user_id);

        return $instance;
    }
}