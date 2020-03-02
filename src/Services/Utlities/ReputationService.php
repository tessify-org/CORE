<?php

namespace Tessify\Core\Services;

use Auth;
use App\Models\User;

class ReputationService
{
    public function awardPoints($points, $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $user->reputation_points += $points;
        $user->save();

        return $user->reputation_points;
    }

    public function takePoints($points, $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $user->reputation_points -= $points;
        $user->save();

        return $user->reputation_points;
    }

    public function determinePoints($urgency = 1)
    {
        $basePoints = config("tessify-core.reputation.base_points");
        dd($basePoints);

        return $basePoints * $urgency;
    }
}