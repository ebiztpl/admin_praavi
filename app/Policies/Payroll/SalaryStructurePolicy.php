<?php

namespace App\Policies\Payroll;

use App\Concerns\SubordinateAccess;
use App\Models\Payroll\SalaryStructure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryStructurePolicy
{
    use HandlesAuthorization, SubordinateAccess;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('salary-structure:read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryStructure  $salaryStructure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SalaryStructure $salaryStructure)
    {
        if (! $user->can('salary-structure:read')) {
            return false;
        }

        if ($salaryStructure?->employee?->team_id != $user->current_team_id) {
            return false;
        }

        return $this->isAccessibleEmployee($salaryStructure->employee);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('salary-structure:create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryStructure  $salaryStructure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SalaryStructure $salaryStructure)
    {
        if (! $user->can('salary-structure:edit')) {
            return false;
        }

        if ($salaryStructure?->employee?->team_id != $user->current_team_id) {
            return false;
        }

        return $this->isAccessibleEmployee($salaryStructure->employee);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryStructure  $salaryStructure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SalaryStructure $salaryStructure)
    {
        if (! $user->can('salary-structure:delete')) {
            return false;
        }

        if ($salaryStructure?->employee?->team_id != $user->current_team_id) {
            return false;
        }

        return $this->isAccessibleEmployee($salaryStructure->employee);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryStructure  $salaryStructure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SalaryStructure $salaryStructure)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryStructure  $salaryStructure
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SalaryStructure $salaryStructure)
    {
        //
    }
}
