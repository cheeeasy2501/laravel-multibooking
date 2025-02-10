<?php

use CheesyTech\LaravelBooking\Enum\Column;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->morphs('bookable');
            $table->morphs('booker');

            if (config('booking.tables.use_period_columns')) {
                $table->dateTimeTz(config('booking.tables.columns' . Column::StartedAt->value));
                $table->dateTimeTz(config('booking.tables.columns' . Column::EndedAt->value));

                $table->index([
                    config('booking.tables.columns.' . Column::StartedAt->value),
                    config('booking.tables.columns.' . Column::EndedAt->value),
                ]);
            }

            $table->timestamps();

            if (config('booking.tables.use_soft_delete')) {
                $table->softDeletes();
            }

            $table->index(['bookable_type', 'bookable_id']);
            $table->index(['booker_type', 'booker_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
