<?php

namespace Tessify\Core\Services\Utilities;

use Auth;
use App\Models\User;
use ReputationTransactions;
use Tessify\Core\Models\ReputationTransaction;

class ReputationService
{
    /**
     * Give points to a user
     * 
     * @param       integer             Number of points to award
     * @param       string              Name of the action performed
     * @param       ????                Model instance to save as target
     * @param       User                User to give points to
     * @return      integer             Total points for the user
     */
    public function givePoints($amount, $name = "", $target = null, $user = null)
    {
        // Grab active user if none is provided
        if (is_null($user)) $user = Auth::user();

        // Create a transaction record
        ReputationTransaction::create([
            "user_id" => $user->id,
            "type" => "give",
            "amount" => $amount,
            "name" => $name,
            "target_type" => is_null($target) ? null : get_class($target),
            "target_id" => is_null($target) ? null : $target->id,
        ]);

        // Update user's reputation points
        $user->reputation_points += $amount;
        $user->save();

        // Return the user's new rep. points
        return $user->reputation_points;
    }

    /**
     * Take points from the user
     * 
     * @param       integer             Number of points to take
     * @param       string              Name of the action performed
     * @param       ????                Model instance to save as target
     * @param       User                User to give points to
     * @return      integer             Total points for the user
     */
    public function takePoints($amount, $name = "", $target = null, $user = null)
    {
        // Grab active user if none is provided
        if (is_null($user)) $user = Auth::user();

        // Create a transaction record
        ReputationTransaction::create([
            "user_id" => $user->id,
            "type" => "take",
            "amount" => $amount,
            "name" => $name,
            "target_type" => is_null($target) ? null : get_class($target),
            "target_id" => is_null($target) ? null : $target->id,
        ]);

        // Update user's rep. points
        $user->reputation_points -= $amount;
        $user->save();

        // Return user's new rep. points
        return $user->reputation_points;
    }

    /**
     * Determine points to award the user based on urgency & base points
     * 
     * @return      integer             Number of points
     */
    public function determinePoints($urgency = 1)
    {
        $basePoints = config("tessify-core.reputation.base_points");

        return $basePoints * $urgency;
    }

    public function getTransactionsForUser($user = null)
    {
        return ReputationTransactions::getAllForUser($user);
    }
}