<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function __construct(
        array $attributes = []
    )
    {
        parent::__construct($attributes);

        $this->table = config('booking.tables.bookings', 'bookings');
    }

    public function booker(): MorphTo
    {
        return $this->morphTo('booker', 'booker_type', 'booker_id');
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo('bookable', 'bookable_type', 'bookable_id');
    }
}
