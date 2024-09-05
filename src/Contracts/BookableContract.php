<?php
declare(strict_types=1);

namespace CheesyTech\LaravelMultiBooking\Contracts;

interface BookableContract
{
    public function getBookableId(): int;

    public function getBookableType(): string;
}