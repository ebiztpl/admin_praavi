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

class Record extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = ['payroll_id', 'pay_head_id'];

    protected $primaryKey = 'id';

    protected $table = 'payroll_records';

    protected $casts = [
        'meta' => 'array',
    ];

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(Payroll::class);
    }

    public function payHead(): BelongsTo
    {
        return $this->belongsTo(PayHead::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('payroll')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
