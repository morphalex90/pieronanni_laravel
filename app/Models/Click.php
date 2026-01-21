<?php

namespace App\Models;

use DeviceDetector\DeviceDetector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Click extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country_id',
        'user_agent',
    ];

    protected $appends = [
        'is_bot',
    ];

    protected function getIsBotAttribute(): bool
    {
        $dd = new DeviceDetector($this->user_agent);
        $dd->parse();

        return $dd->isBot();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
