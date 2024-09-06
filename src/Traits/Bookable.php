<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Traits;

use CheesyTech\LaravelBooking\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Bookable
{
    public function bookers(): MorphMany
    {
        /** @var Model $this */

        return $this->morphMany(Booking::class, 'bookable', 'bookable_type', 'bookable_id');
    }

    public static function bootBookable(): void
    {
        static::deleted(function ($model) {
            $model->bookings()->delete();
        });
    }
}
