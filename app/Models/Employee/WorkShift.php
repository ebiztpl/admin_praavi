<?php

namespace App\Models\Employee;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Models\Attendance\WorkShift as AttendanceWorkShift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkShift extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = [];

    protected $primaryKey = 'id';

    protected $table = 'employee_work_shifts';

    protected $casts = [
        'meta' => 'array',
    ];

    public function getModelName(): string
    {
        return 'EmployeeWorkShift';
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function workShift(): BelongsTo
    {
        return $this->belongsTo(AttendanceWorkShift::class, 'work_shift_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('employee')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
