<?php

namespace App\Policies\Attendance;

use App\Models\Attendance\Timesheet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimesheetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can fetch prerequisites any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function preRequisite(User $user)
    {
        return $user->can('timesheet:create') || $user->can('timesheet:edit');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('timesheet:read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\Timesheet  $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Timesheet $timesheet)
    {
        return $user->can('timesheet:read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('timesheet:create');
    }

    /**
     * Determine whether the user can mark models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function mark(User $user)
    {
        return $user->can('timesheet:mark');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\Timesheet  $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Timesheet $timesheet)
    {
        return $user->can('timesheet:edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\Timesheet  $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Timesheet $timesheet)
    {
        return $user->can('timesheet:delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\Timesheet  $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Timesheet $timesheet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\Timesheet  $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Timesheet $timesheet)
    {
        //
    }
}
