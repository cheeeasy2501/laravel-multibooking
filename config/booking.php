<?php

use CheesyTech\LaravelBooking\Booking;

return [
    'models' => [
        'booking' => Booking::class,
        'booker' => 'App\\Models\\User',
    ],

    'tables' => [
        'bookings' => env('BOOKING_TABLES','bookings'),
    ]
];