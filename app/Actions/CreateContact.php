<?php

namespace App\Actions;

use App\Models\Contact;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateContact
{
    public function execute($params = []) : Contact
    {
        Validator::make($params, [
            'email' => 'required_without:contact_number|email',
            'contact_number' => 'required_without:email|string',
        ], [], [
            'email' => trans('contact.props.email'),
            'contact_number' => trans('contact.props.contact_number'),
        ])->validate();

        $name = Arr::get($params, 'name') ? $this->splitName(Arr::get($params, 'name')) : [];

        $firstName = Arr::get($name ?: $params, 'first_name');
        $middleName = Arr::get($name ?: $params, 'middle_name');
        $thirdName = Arr::get($name ?: $params, 'third_name');
        $lastName = Arr::get($name ?: $params, 'last_name');

        $contact = Contact::query()
            ->byTeam()
            ->whereFirstName($firstName)
            ->whereMiddleName($middleName)
            ->whereThirdName($thirdName)
            ->whereLastName($lastName)
            ->whereContactNumber(Arr::get($params, 'contact_number'))
            ->first();

        if ($contact) {
            return $contact;
        }

        return Contact::forceCreate([
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'third_name' => $thirdName,
            'last_name' => $lastName,
            'team_id' => session('team_id'),
            'contact_number' => Arr::get($params, 'contact_number'),
            'birth_date' => Arr::get($params, 'birth_date'),
            'gender' => Arr::get($params, 'gender'),
        ]);
    }

    private function splitName($string): array
    {
        $array = explode(' ', $string);
        $num = count($array);
        $first_name = $middle_name = $third_name = $last_name = null;

        if ($num == 1) {
            [$first_name] = $array;
        } elseif ($num == 2) {
            [$first_name, $last_name] = $array;
        } elseif ($num == 3) {
            [$first_name, $middle_name, $last_name] = $array;
        } else {
            [$first_name, $middle_name, $third_name, $last_name] = $array;
        }

        return compact(
            'first_name', 'middle_name', 'third_name', 'last_name'
        );
    }
}
