<?php

namespace App\Policies\Leave;

use App\Concerns\SubordinateAccess;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization, SubordinateAccess;

    /**
     * Determine whether the user can fetch prerequisites any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function preRequisite(User $user)
    {
        return $user->can('leave-request:create') || $user->can('leave-request:edit');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('leave-request:read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\Request  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LeaveRequest $leaveRequest)
    {
        if (! $user->can('leave-allocation:read')) {
            return false;
        }

        if ($leaveRequest?->employee?->team_id != $user->current_team_id) {
            return false;
        }

        if ($user->id == $leaveRequest->employee->user_id) {
            return true;
        }

        return $this->isAccessibleEmployee($leaveRequest->employee);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('leave-request:create');
    }

    /**
     * Determine whether the user can take action on the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\Request  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function action(User $user, LeaveRequest $leaveRequest)
    {
        if (! $user->can('leave-request:action')) {
            return false;
        }

        if ($leaveRequest?->employee?->team_id != $user->current_team_id) {
            return false;
        }

        return $this->isAccessibleEmployee($leaveRequest->employee);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\Request  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LeaveRequest $leaveRequest)
    {
        if (! $user->can('leave-request:edit')) {
            return false;
        }

        if ($leaveRequest?->employee?->team_id != $user->current_team_id) {
            return false;
        }

        if ($user->id == $leaveRequest->employee->user_id) {
            return true;
        }

        return $this->isAccessibleEmployee($leaveRequest->employee);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\Request  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LeaveRequest $leaveRequest)
    {
        if (! $user->can('leave-request:edit')) {
            return false;
        }

        if ($leaveRequest?->employee?->team_id != $user->current_team_id) {
            return false;
        }

        if ($user->id == $leaveRequest->employee->user_id) {
            return true;
        }

        return $this->isAccessibleEmployee($leaveRequest->employee);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\Request  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LeaveRequest $leaveRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\Request  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LeaveRequest $leaveRequest)
    {
        //
    }
}
