<?php

namespace App\Policies\Attendance;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can fetch prerequisites.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function preRequisite(User $user)
    {
        return $user->can('attendance:mark');
    }

    /**
     * Determine whether the user can list attendance.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function list(User $user)
    {
        return $user->can('attendance:read');
    }

    /**
     * Determine whether the user can mark attendance.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function mark(User $user)
    {
        return $user->can('attendance:mark');
    }
}
