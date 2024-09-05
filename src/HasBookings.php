<?php
declare(strict_types=1);

namespace CheesyTech\LaravelMultiBooking;

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
        return $this->bookings()->create([
            'bookable_id' => $bookable->getBookableId(),
            'bookable_type' => $bookable->getBookableType(),
        ]);
    }

    public function deleteBooking(BookableContract $bookable): bool
    {
        return (bool)$this->bookings()
            ->where([
                'bookable_id' => $bookable->getBookableId(),
                'bookable_type' => $bookable->getBookableType(),
            ])
            ->delete();
    }
}