<?php

namespace App\Models\Leave;

use App\Concerns\HasDatePeriod;
use App\Concerns\HasFilter;
use App\Concerns\HasMedia;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Contracts\Mediable;
use App\Helpers\CalHelper;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Request extends Model implements Mediable
{
    use HasFactory, HasFilter, HasUuid, HasMeta, HasMedia, HasDatePeriod, LogsActivity;

    protected $fillable = [];

    protected $primaryKey = 'id';

    protected $table = 'leave_requests';

    protected $casts = [
        'meta' => 'array',
    ];

    public function getModelName(): string
    {
        return 'LeaveRequest';
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'leave_type_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_id');
    }

    public function records(): HasMany
    {
        return $this->hasMany(RequestRecord::class, 'leave_request_id');
    }

    public function getPeriodAttribute()
    {
        return CalHelper::getPeriod($this->start_date, $this->end_date);
    }

    public function getDurationAttribute()
    {
        return CalHelper::getDuration($this->start_date, $this->end_date, 'day');
    }

    public function scopeByTeam(Builder $query)
    {
        $query->whereHas('employee', function ($q) {
            $q->byTeam();
        });
    }

    public function scopeFindIfExists(Builder $query, string $uuid, $field = 'message'): self
    {
        return $query->whereUuid($uuid)
            ->with(['employee' => fn ($q) => $q->withFullRecordDetail(), 'type'])
            ->getOrFail(trans('leave.request.request'), $field);
    }

    public function scopeFindWithDetailIfExists(Builder $query, string $uuid): self
    {
        return $query->whereUuid($uuid)
            ->addSelect([
                'comment' => RequestRecord::select('comment')
                    ->whereColumn('leave_request_id', 'leave_requests.id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1),
            ])
            ->with(['employee' => fn ($q) => $q->withFullRecordDetail(), 'type'])
            ->getOrFail(trans('leave.request.request'));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('leave_request')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
