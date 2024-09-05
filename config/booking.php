<?php

use CheesyTech\LaravelBooking\Booking;
use CheesyTech\LaravelBooking\Enum\Column;

return [
    'models' => [
        'booking' => Booking::class,
        'booker' => 'App\\Models\\User',
    ],

    'tables' => [
        'bookings' => env('BOOKING_TABLES','bookings'),
        'columns' => [
            Column::StartedAt->value => env('BOOKING_TABLE_STARTED_AT','started_at'),
            Column::EndedAt->value => env('BOOKING_TABLE_ENDED_AT','ended_at'),
        ]
    ]
];