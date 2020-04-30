<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Tessify\Core\Models\Faq;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class FaqService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Faq";
    }
    
    public function preload($instance)
    {
        return $instance;
    }
}