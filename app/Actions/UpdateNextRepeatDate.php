<?php

namespace App\Actions;

use App\Actions\GetNextRepeatDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class UpdateNextRepeatDate
{
    public function execute(Model $model): void
    {
        $repeatation = $model->repeatation;
        $repeatation['last_repeat_date'] = $repeatation['next_repeat_date'];
        $model->repeatation = $repeatation;

        $nextRepeateDate = (new GetNextRepeatDate)->execute($model->repeatation);

        $repeatation['next_repeat_date'] = $nextRepeateDate;
        $repeatation['repeated_count'] = Arr::get($repeatation, 'repeated_count', 0) + 1;
        $model->repeatation = $repeatation;

        $model->save();
    }
}
