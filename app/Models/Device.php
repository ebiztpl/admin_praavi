<?php

namespace App\Models;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Device extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $fillable = [];

    protected $primaryKey = 'id';

    protected $table = 'devices';

    protected $casts = [
        'meta' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeByTeam(Builder $query)
    {
        $query->whereTeamId(session('team_id'));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('device')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
