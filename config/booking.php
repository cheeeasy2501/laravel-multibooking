<?php

use CheesyTech\LaravelBooking\Booking;
use CheesyTech\LaravelBooking\Enum\Column;

return [
    'models' => [
        'booking' => Booking::class,
    ],

    'tables' => [
        'bookings' => env('BOOKING_TABLES', 'bookings'),
        'columns' => [
            Column::StartedAt->value => env('BOOKING_TABLE_STARTED_AT', 'started_at'),
            Column::EndedAt->value => env('BOOKING_TABLE_ENDED_AT', 'ended_at'),
        ],
        'use_soft_delete' => env('BOOKING_TABLE_SOFT_DELETED', true),
    ],

    'use_period_columns' => env('BOOKING_USE_PERIOD_COLUMNS', true),
];