<?php

namespace App\Models\Payroll;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SalaryStructureRecord extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = ['salary_structure_id', 'pay_head_id'];

    protected $primaryKey = 'id';

    protected $table = 'salary_structure_records';

    protected $casts = [
        'meta' => 'array',
    ];

    public function structure(): BelongsTo
    {
        return $this->belongsTo(SalaryTemplate::class);
    }

    public function payHead(): BelongsTo
    {
        return $this->belongsTo(PayHead::class);
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
