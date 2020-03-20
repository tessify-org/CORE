<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use App\Models\User;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Models\ReputationTransaction;
use Tessify\Core\Contracts\ModelServiceContract;

class ReputationTransactionService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\ReputationTransaction";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getAllForUser(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($this->getAll() as $transaction)
        {
            if ($transaction->user_id == $user->id)
            {
                $out[] = $this->preload($transaction);
            }
        }

        return collect($out);
    }
}