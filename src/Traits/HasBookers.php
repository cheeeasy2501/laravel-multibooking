<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Traits;

use CheesyTech\LaravelBooking\Booking;
use CheesyTech\LaravelBooking\Contracts\BookableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;

trait HasBookers
{
    public function bookers(string|array $bookerType = null): MorphMany
    {
        /** @var Model $this */

        $query = $this->morphMany(Booking::class, 'bookable', 'bookable_type', 'bookable_id');

        if ($bookerType) {
            $queryCallback = match (is_array($bookerType)) {
                true => function (Builder $query) use ($bookerType, $query): Builder {
                    $validTypes = array_filter($bookerType, function (mixed $type) {
                        return class_exists($type) && in_array(BookableContract::class, class_implements($type));
                    });

                    return $query->whereIn('bookable_type', $validTypes);
                },
                false => fn(Builder $query): Builder => $query->whereIn('bookable_type', $bookerType)
            };

            $query = $queryCallback();
        }

        return $query;
    }
}
