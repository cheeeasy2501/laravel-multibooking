<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Traits;

use CheesyTech\LaravelBooking\Booking;
use CheesyTech\LaravelBooking\Contracts\BookableContract;
use CheesyTech\LaravelBooking\Contracts\BookerContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;

trait HasBookings
{
    public function bookings(string|array $bookableType = null): MorphMany
    {
        /** @var Model $this */
        $query = $this->morphMany(Booking::class, 'bookable', 'booker_type', 'booker_id');

        if ($bookableType) {
            $queryCallback = match (is_array($bookableType)) {
                true => function (Builder $query) use ($bookableType, $query): Builder {
                    $validTypes = array_filter($bookableType, function (mixed $type) {
                        return class_exists($type) && in_array(BookableContract::class, class_implements($type));
                    });

                    return $query->whereIn('bookable_type', $validTypes);
                },
                false => fn(Builder $query): Builder => $query->whereIn('bookable_type', $bookableType)
            };

            $query = $queryCallback();
        }

        return $query;
    }

    public function findBooking(int|string $bookableId, string|array $bookableType): MorphMany
    {
        return $this->bookings($bookableType)->where('bookable_id,' . $bookableId);
    }

    public function newBooking(BookableContract $bookable): Model
    {
        /** @var BookerContract $this */
        return $this->bookings()->create([
            'bookable_id' => $bookable->getBookableId(),
            'bookable_type' => $bookable->getBookableType(),
            'booker_id' => $this->getBookerId(),
            'booker_type' => $this->getBookerType(),
        ]);
    }

    public function deleteAllBookings(BookableContract $bookable): int
    {
        /** @var BookerContract $this */
        return $this->bookings()
            ->where([
                'bookable_id' => $bookable->getBookableId(),
                'bookable_type' => $bookable->getBookableType(),
                'booker_id' => $this->getBookerId(),
                'booker_type' => $this->getBookerType(),
            ])
            ->delete();
    }
}