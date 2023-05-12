<?php

namespace App\Models\Attendance;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Timesheet extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = [];

    protected $primaryKey = 'id';

    protected $table = 'timesheets';

    protected $casts = [
        'meta' => 'array',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function workShift(): BelongsTo
    {
        return $this->belongsTo(WorkShift::class);
    }

    public function scopeFindIfExists(Builder $query, string $uuid, $field = 'message')
    {
        return $query->whereUuid($uuid)
            ->with(['employee' => fn ($q) => $q->withFullRecordDetail()])
            ->getOrFail(trans('attendance.timesheet.timesheet'), $field);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('timesheet')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
