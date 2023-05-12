<?php

namespace App\Support;

trait HasPhoto
{
    public function getPhoto(?string $photo = '', ?string $gender = 'male')
    {
        if (empty($gender)) {
            $gender = 'male';
        }

        $default = '/images/'.$gender.'.png';

        if (empty($photo)) {
            return $default;
        }

        if (! \Storage::disk('public')->exists(str_replace('/storage/', '', $photo))) {
            return $default;
        }

        return $photo;
    }
}
