<?php

namespace App\Models\Attendance;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Record extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = ['attendance_id', 'attendance_type_id'];

    protected $primaryKey = 'id';

    protected $table = 'attendance_records';

    protected $casts = [
        'meta' => 'array',
    ];

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'attendance_type_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('attendance')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
