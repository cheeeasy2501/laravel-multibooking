# Laravel Multi-Booking

**Laravel Mutli-Booking** is a flexible multi-booking system for Laravel applications. It allows users to book various processes (e.g., training sessions, seminars) that implement the `BookableContract`.

## Installation

To install the package, simply run:

```bash
composer require cheeasytech/laravel-multi-booking
```

## Publish Config and Migrations
Once installed, you can publish the configuration file and migrations:
```bash
php artisan vendor:publish --provider="CheesyTech\LaravelMultiBooking\BookingServiceProvider" --tag="config"
php artisan vendor:publish --provider="CheesyTech\LaravelMultiBooking\BookingServiceProvider" --tag="migrations"
```

Run the migrations to create the necessary tables:
```bash
php artisan migrate
```

## Configuration

In the <code>config/booking.php</code> file, set the user model for the system:

```php
return [
    'user_model' => \App\Models\User::class,
];
```

## Usage

### Defining Bookable Entities

Any process that can be booked (like a seminar or a training session) should implement the **BookableContract**. 

For example:
```php
namespace App\Models;

use CheeasyTech\LaravelMultiBooking\BookableContract;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model implements BookableContract
{
    public function getBookableId(): int
    {
        return $this->id;
    }

    public function getBookableType(): string
    {
        return static::class;
    }
}
```

### User Bookings

Users can book processes (e.g., training sessions) using the book method.

```php
// Get all bookings for a user
$user->bookings;
```

