<?php

namespace Tessify\Core\Services\ModelServices;

use App\Models\User;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class NotificationService extends ModelService
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Notification";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getNumUnread(User $user = null)
    {

    }

    public function getUnread(User $user = null)
    {
        
    }

    public function get(User $user = null)
    {

    }
}