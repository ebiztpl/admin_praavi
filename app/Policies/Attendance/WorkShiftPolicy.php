<?php

namespace App\Policies\Attendance;

use App\Models\Attendance\WorkShift;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkShiftPolicy
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
        return $user->can('work-shift:create') || $user->can('work-shift:edit');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('work-shift:read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\WorkShift  $workShift
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, WorkShift $workShift)
    {
        return $user->can('work-shift:read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('work-shift:create');
    }

    /**
     * Determine whether the user can assign models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function assign(User $user)
    {
        return $user->can('work-shift:assign');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\WorkShift  $workShift
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, WorkShift $workShift)
    {
        return $user->can('work-shift:edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\WorkShift  $workShift
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, WorkShift $workShift)
    {
        return $user->can('work-shift:delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\WorkShift  $workShift
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, WorkShift $workShift)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance\WorkShift  $workShift
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, WorkShift $workShift)
    {
        //
    }
}
