<?php

namespace CheesyTech\LaravelMultiBooking\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

trait IntersectWithBookingScopes
{
    public function pastBookings(): MorphMany
    {
        /** @var HasBookings $this */
        return $this->bookings()
            ->where('ends_at', '<', Carbon::now());
    }

    public function futureBookings(): MorphMany
    {
        /** @var HasBookings $this */
        return $this->bookings()
            ->where('starts_at', '>',  Carbon::now());
    }

    public function currentBookings(): MorphMany
    {
        /** @var HasBookings $this */
        return $this->bookings()
            ->where('starts_at', '<', Carbon::now())
            ->where('ends_at', '>',  Carbon::now());
    }
}