<?php

namespace App\Actions;

use App\Models\Contact;
use App\Models\Employee\Employee;
use App\Models\Team;

class TeamSetup
{
    public function execute(Team $team) : void
    {
        $contact = Contact::first();

        $newContact = $contact->replicate();
        $newContact->team_id = $team->id;
        $newContact->save();

        Employee::forceCreate([
            'number_format' => 'SA%NUMBER%',
            'number' => 1,
            'code_number' => 'SA1',
            'joining_date' => today()->toDateString(),
            'contact_id' => $newContact->id,
            'meta' => ['is_default' => true]
        ]);
    }
}