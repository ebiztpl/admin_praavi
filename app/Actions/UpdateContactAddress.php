<?php

namespace App\Actions;

use App\Models\Contact;
use Illuminate\Support\Arr;

class UpdateContactAddress
{
    public function execute(Contact $contact, array $address = []) : Contact
    {
        $contactAddress = $contact->address;

        $contactAddress['present'] = [
            'address_line1' => Arr::get($address, 'address_line1'),
            'address_line2' => Arr::get($address, 'address_line2'),
            'city' => Arr::get($address, 'city'),
            'state' => Arr::get($address, 'state'),
            'zipcode' => Arr::get($address, 'zipcode'),
            'country' => Arr::get($address, 'country'),
        ];

        $contact->address = $contactAddress;

        $contact->save();

        return $contact;
    }
}
