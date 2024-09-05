<?php
declare(strict_types=1);

namespace CheesyTech\LaravelMultiBooking;

interface BookableContract
{
    public function getBookableId(): int;

    public function getBookableType(): string;
}