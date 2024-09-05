<?php
declare(strict_types=1);

namespace CheesyTech\LaravelMultiBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Bookable
{
    public function bookedUsers(): MorphToMany
    {
        /** @var Model $this */
        return $this->morphToMany(config('booking.user_model'), 'bookable', 'bookings');
    }
}