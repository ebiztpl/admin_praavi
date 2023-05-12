<?php

namespace App\Models\Payroll;

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

class SalaryStructure extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = [];

    protected $primaryKey = 'id';

    protected $table = 'salary_structures';

    protected $casts = [
        'meta' => 'array',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(SalaryTemplate::class, 'salary_template_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(SalaryStructureRecord::class, 'salary_structure_id');
    }

    public function scopeFindIfExists(Builder $query, string $uuid, $field = 'message')
    {
        return $query->whereUuid($uuid)
            ->with(['employee' => fn ($q) => $q->withFullRecordDetail(), 'records'])
            ->getOrFail(trans('payroll.salary_structure.salary_structure'), $field);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('salary_structure')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
