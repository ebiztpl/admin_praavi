<?php

namespace App\Models\Leave;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AllocationRecord extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = ['leave_allocation_id', 'leave_type_id'];

    protected $primaryKey = 'id';

    protected $table = 'leave_allocation_records';

    protected $casts = [
        'meta' => 'array',
    ];

    public function allocation(): BelongsTo
    {
        return $this->belongsTo(Allocation::class, 'leave_allocation_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'leave_type_id');
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
