<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ClickObserver;
use DeviceDetector\DeviceDetector;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ClickObserver::class)]
final class Click extends Model
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

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    protected function getIsBotAttribute(): bool
    {
        $dd = new DeviceDetector($this->user_agent);
        $dd->parse();

        return $dd->isBot();
    }
}
