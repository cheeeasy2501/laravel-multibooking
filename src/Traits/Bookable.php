<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Bookable
{
    public function bookers(): MorphToMany
    {
        /** @var Model $this */
        return $this->morphToMany(
            related: config('booking.models.booker'),
            name: 'bookable',
            table: config('booking.tables.bookings'),
            foreignPivotKey: 'bookable_id',
            relatedPivotKey: 'booker_id');
    }

    public function booker()
    {
        return $this->bookers()->first();
    }

    public static function bootBookable(): void
    {
        static::deleted(function ($model) {
            $model->bookings()->delete();
        });
    }
}