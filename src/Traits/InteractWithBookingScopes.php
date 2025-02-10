<?php

namespace CheesyTech\LaravelBooking\Traits;

use CheesyTech\LaravelBooking\Enum\Column;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

trait InteractWithBookingScopes
{
    protected function target()
    {
        /** @var HasBookings|HasBookers $this */
        $usedTraits = class_uses($this);

        if (in_array(HasBookings::class, $usedTraits)) {
            return $this->bookings();
        } elseif (in_array(HasBookers::class, $usedTraits)) {
            return $this;
        }

        throw new \RuntimeException('Neither HasBookings nor Bookable trait is used.');
    }

    protected function columns(): array
    {
        return [
            Column::StartedAt->value => method_exists($this, 'statedAtColumn')
                ? $this->statedAtColumn()
                : config('booking.tables.columns.' . Column::StartedAt->value),
            Column::EndedAt->value => method_exists($this, 'endedAtColumn')
                ? $this->endedAtColumn()
                : config('booking.tables.columns.' . Column::EndedAt->value),
        ];
    }

    protected function column(Column $column)
    {
        return $this->columns()[$column->value];
    }

    public function pastBookings(): MorphMany
    {
        /** @var HasBookings|HasBookers $this */
        return $this->target()
            ->where($this->column(Column::EndedAt), '<', Carbon::now());
    }

    public function futureBookings(): MorphMany
    {
        /** @var HasBookings|HasBookers $this */
        return $this->target()
            ->where($this->column(Column::StartedAt), '>', Carbon::now());
    }

    public function currentBookings(): MorphMany
    {
        /** @var HasBookings|HasBookers $this */
        return $this->target()
            ->where($this->column(Column::StartedAt), '<', Carbon::now())
            ->where($this->column(Column::EndedAt), '>', Carbon::now());
    }
}
