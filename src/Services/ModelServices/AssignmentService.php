<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Dates;
use AssignmentTypes;
use Organizations;
use OrganizationTypes;
use OrganizationLocations;
use OrganizationDepartments;
use App\Models\User;
use Tessify\Core\Models\Assignment;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Assignments\CreateAssignmentRequest;
use Tessify\Core\Http\Requests\Assignments\UpdateAssignmentRequest;
use Tessify\Core\Http\Requests\Api\Assignments\CreateAssignmentRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Assignments\UpdateAssignmentRequest as ApiUpdateRequest;

class AssignmentService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Assignment";
    }
    
    public function preload($instance)
    {
        $instance->type = AssignmentTypes::find($instance->assignment_type_id);
        $instance->organization = Organizations::findPreloaded($instance->organization_id);
        $instance->department = OrganizationDepartments::find($instance->organization_department_id);

        return $instance;
    }

    public function findAllPreloadedForUser(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($this->getAllPreloaded() as $assignment)
        {
            if ($assignment->user_id == $user->id)
            {
                $out[] = $assignment;
            }
        }

        return $out;
    }

    public function createFromApiRequest(ApiCreateRequest $request)
    {
        // Grab current user
        $user = Auth::user();

        // Determine the order for this assignment
        $order = $user->assignments->count();

        // Determine if this is the current assignment of the user
        $current = $request->current == "true" ? true : false;
        if ($current && $user->assignments->count())
        {
            $this->deactiveAllForUser($user);
        }

        // Retrieve or create the organization
        $organization = Organizations::findOrCreateByName($request->organization);

        // Retrieve or create the organization's department
        $department = OrganizationDepartments::findOrCreateByName($organization, $request->department);

        // Parse the dates
        $start_date = Dates::parse($request->start_date, "-")->format("Y-m-d");
        $end_date = $request->end_date == "null" ? null : Dates::parse($request->end_date, "-")->format("Y-m-d");
        
        // Create and return the assignment
        return $this->preload(Assignment::create([
            "user_id" => $user->id,
            "assignment_type_id" => $request->assignment_type_id,
            "organization_id" => $organization->id,
            "organization_department_id" => $department->id,
            "organization_location_id" => $request->organization_location_id,
            "title" => $request->title,
            "description" => $request->description,
            "order" => $order,
            "current" => $current,
            "start_date" => $start_date,
            "end_date" => $end_date
        ]));
    }

    public function updateFromApiRequest(ApiUpdateRequest $request)
    {

    }

    public function deactiveAllForUser(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        foreach ($user->assignments as $assignment)
        {
            $assignment->current = false;
            $assignment->save();
        }
    }
}