<?php
declare(strict_types=1);

namespace CheesyTech\LaravelMultiBooking\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Bookable
{
    public function bookers(): MorphToMany
    {
        /** @var Model $this */
        return $this->morphToMany(config('booking.models.booker'), 'bookable', config('booking.tables.bookings'));
    }

    public static function bootBookable(): void
    {
        static::deleted(function ($model) {
            $model->bookings()->delete();
        });
    }
}