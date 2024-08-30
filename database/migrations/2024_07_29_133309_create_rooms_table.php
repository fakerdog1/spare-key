<?php

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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('property_url');
            $table->integer('max_persons');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('total_price', 10, 2)->default(0.00);

            $table->boolean('is_booked')->default(false);
            $table->boolean('is_private')->default(true);
            $table->boolean('is_democracy')->default(false);

            $table->timestamp('date_from');
            $table->timestamp('date_to');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
