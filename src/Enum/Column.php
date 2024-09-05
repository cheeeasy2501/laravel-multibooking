<?php

namespace CheesyTech\LaravelBooking\Enum;

enum Column: string
{
    case StartedAt = 'started_at';
    case EndedAt = 'ended_at';
}
