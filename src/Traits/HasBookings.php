<?php
declare(strict_types=1);

namespace CheesyTech\LaravelMultiBooking\Traits;

use CheesyTech\LaravelMultiBooking\Booking;
use CheesyTech\LaravelMultiBooking\Contracts\BookableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasBookings
{
    public function bookings(string|array $type = null): MorphMany
    {
        /** @var Model $this */
        $query = $this->morphMany(Booking::class, 'bookable');

        if ($type) {
            $types = is_array($type) ? $type : [$type];

            $validTypes = array_filter($types, function ($type) {
                return class_exists($type) && in_array(BookableContract::class, class_implements($type));
            });

            $query->whereIn('bookable_type', $validTypes);
        }

        return $query;
    }

    public function newBooking(BookableContract $bookable): Model
    {
        /** @var Model $this */
        return $this->bookings()->create([
            'bookable_id' => $bookable->getBookableId(),
            'bookable_type' => $bookable->getBookableType(),
            'booker_id' => $this->getKey(),
            'booker_type' => $this->getMorphClass(),
        ]);
    }

    public function deleteBooking(BookableContract $bookable): int
    {
        /** @var Model $this */
        return $this->bookings()
            ->where([
                'bookable_id' => $bookable->getBookableId(),
                'bookable_type' => $bookable->getBookableType(),
                'booker_id' => $this->getKey(),
                'booker_type' => $this->getMorphClass(),
            ])
            ->delete();
    }
}