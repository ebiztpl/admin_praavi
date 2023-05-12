<?php

namespace App\Models\Leave;

use App\Concerns\HasDatePeriod;
use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Allocation extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, HasDatePeriod, LogsActivity;

    protected $fillable = [];

    protected $primaryKey = 'id';

    protected $table = 'leave_allocations';

    protected $casts = [
        'meta' => 'array',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(AllocationRecord::class, 'leave_allocation_id');
    }

    public function scopeByTeam(Builder $query)
    {
        $query->whereHas('employee', function ($q) {
            $q->whereHas('contact', function ($q) {
                $q->whereTeamId(session('team_id'));
            });
        });
    }

    public function scopeFindIfExists(Builder $query, string $uuid, $field = 'message')
    {
        return $query->whereUuid($uuid)
            ->with(['employee' => fn ($q) => $q->withFullRecordDetail(), 'records', 'records.type'])
            ->getOrFail(trans('leave.allocation.allocation'), $field);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('leave_allocation')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
