<?php
declare(strict_types=1);

namespace CheesyTech\LaravelBooking\Contracts;

interface BookableContract
{
    public function getBookableId(): int;

    public function getBookableType(): string;
}