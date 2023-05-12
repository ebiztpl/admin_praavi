<?php

namespace App\Policies\Payroll;

use App\Models\Payroll\SalaryTemplate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryTemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can get pre-requisite.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function preRequisite(User $user)
    {
        return $user->hasAnyPermission(['salary-template:read', 'salary-template:create', 'salary-template:edit']);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('salary-template:read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryTemplate  $salaryTemplate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SalaryTemplate $salaryTemplate)
    {
        return $user->can('salary-template:read') && $salaryTemplate->team_id == $user->current_team_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('salary-template:create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryTemplate  $salaryTemplate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SalaryTemplate $salaryTemplate)
    {
        return $user->can('salary-template:edit') && $salaryTemplate->team_id == $user->current_team_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryTemplate  $salaryTemplate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SalaryTemplate $salaryTemplate)
    {
        return $user->can('salary-template:delete') && $salaryTemplate->team_id == $user->current_team_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryTemplate  $salaryTemplate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SalaryTemplate $salaryTemplate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payroll\SalaryTemplate  $salaryTemplate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SalaryTemplate $salaryTemplate)
    {
        //
    }
}
