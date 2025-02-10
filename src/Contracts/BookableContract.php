<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface BookableContract
{
    public function getBookableId(): int;

    public function getBookableType(): string;

    public function bookers(string|array|null $bookerType = null): HasMany;
}