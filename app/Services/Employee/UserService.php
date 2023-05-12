<?php

namespace App\Services\Employee;

use App\Enums\UserStatus;
use App\Http\Resources\UserSummaryResource;
use App\Models\Contact;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role as SpatieRole;

class UserService
{
    private function ensureEmailDoesntBelongToOtherContact(Request $request, Employee $employee)
    {
        $emailBelongsToOtherContact = Contact::query()
            ->byTeam()
            ->where('id', '!=', $employee->contact_id)
            ->where('email', $request->email)
            ->exists();

        if ($emailBelongsToOtherContact) {
            throw ValidationException::withMessages(['message' => trans('contact.login.email_belongs_to_other_contact')]);
        }
    }

    private function ensureEmailDoesntBelongToUserContact(Request $request)
    {
        $emailBelongsToUser = User::whereEmail($request->email)->first();

        if ($emailBelongsToUser) {
            $userBelongsToContact = Contact::whereUserId($emailBelongsToUser->id)->exists();

            if ($userBelongsToContact) {
                throw ValidationException::withMessages(['message' => trans('contact.login.email_belongs_to_team_member')]);
            }
        }
    }

    public function confirm(Request $request, Employee $employee): ?UserSummaryResource
    {
        $request->validate([
            'email' => 'required|email',
        ], [], [
            'email' => trans('contact.login.props.email'),
        ]);

        $this->ensureEmailDoesntBelongToUserContact($request);

        $this->ensureEmailDoesntBelongToOtherContact($request, $employee);

        $user = User::whereEmail($request->email)->first();

        return $user ? UserSummaryResource::make($user) : null;
    }

    public function fetch(Employee $employee): array|UserSummaryResource
    {
        $employee->load('contact.user.roles');

        if (! $employee->user_id) {
            return [];
        }

        return UserSummaryResource::make($employee->contact->user);
    }

    public function create(Request $request, Employee $employee)
    {
        $this->ensureEmailDoesntBelongToOtherContact($request, $employee);

        $this->ensureEmailDoesntBelongToUserContact($request);

        $employee->load('contact.user');

        $user = $employee->contact?->user;

        if ($user) {
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_action')]);
        }

        \DB::beginTransaction();

        $user = User::forceCreate([
            'name' => $employee->contact->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'status' => UserStatus::ACTIVATED->value,
        ]);

        $user->assignRole(SpatieRole::find($request->role_ids));

        $contact = $employee->contact;
        $contact->user_id = $user->id;
        $contact->save();

        \DB::commit();
    }

    public function update(Request $request, Employee $employee)
    {
        $this->ensureEmailDoesntBelongToOtherContact($request, $employee);

        $employee->load('contact.user');

        $contact = $employee->contact;

        $user = $contact?->user ?? User::whereEmail($request->email)->first();

        if (! $user) {
            throw ValidationException::withMessages(['message' => trans('global.could_not_find', ['attribute' => trans('user.user')])]);
        }

        if (Contact::whereUserId($user->id)->where('id', '!=', $employee->contact_id)->exists()) {
            throw ValidationException::withMessages(['message' => 'contact.login.email_belongs_to_team_member']);
        }

        \DB::beginTransaction();

        $contact->user_id = $user->id;
        $contact->save();

        \DB::table('model_has_roles')->whereModelType('User')->whereModelId($user->id)->whereTeamId(session('team_id'))->delete();

        $user->assignRole(SpatieRole::find($request->role_ids));

        \DB::commit();
    }
}
