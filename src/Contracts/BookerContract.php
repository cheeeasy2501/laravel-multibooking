<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface BookerContract
{
    public function getBookerId(): int;

    public function getBookerType(): string;

    public function bookings(string|array $bookableType = null): MorphMany;
}