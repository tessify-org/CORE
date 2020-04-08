<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\NewsletterSignup;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Api\Newsletter\SignupForNewsletterRequest;

class NewsletterService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\NewsletterSignup";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function createFromRequest(SignupForNewsletterRequest $request)
    {
        return NewsletterSignup::create([
            "user_id" => auth()->check() ? auth()->user()->id : null,
            "email" => $request->email,
        ]);
    }
}