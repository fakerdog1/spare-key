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
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('property_url')->nullable()->change();
            $table->integer('max_persons')->nullable()->change();
            $table->float('price')->nullable()->change();
            $table->float('total_price')->nullable()->change();
            $table->dateTime('date_from')->nullable()->change();
            $table->dateTime('date_to')->nullable()->change();
            $table->integer('creation_step')->default(1)->after('date_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('property_url')->nullable(false)->change();
            $table->integer('max_persons')->nullable(false)->change();
            $table->float('price')->nullable(false)->change();
            $table->float('total_price')->nullable(false)->change();
            $table->dateTime('date_from')->nullable(false)->change();
            $table->dateTime('date_to')->nullable(false)->change();
            $table->dropColumn('creation_step');
        });
    }
};
