<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface BookerContract
{
    public function getBookerId(): int;

    public function getBookerType(): string;

    public function bookables(): HasMany;
}