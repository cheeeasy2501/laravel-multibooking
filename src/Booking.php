<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookable_id',
        'bookable_type',
        'booker_id',
        'booker_type',
    ];

    protected $casts = [
        'bookable_id' => 'integer',
        'booker_id' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('booking.tables.bookings');
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function booker(): BelongsTo
    {
        return $this->belongsTo(config('booking.models.booker'), 'booker_id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(config('booking.models.booking'), 'booker_id');
    }
}
