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

        Schema::create('map_points', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();
            $table->integer('country');
            $table->integer('region');
            $table->integer('type');
            $table->integer('model');
            $table->float('lat', 8, 6);
            $table->float('lng', 8, 6);
            $table->integer('direction');
            $table->integer('distance');
            $table->integer('angle');
            $table->integer('carSpeed');
            $table->integer('truckSpeed');
            $table->integer('status');
            $table->integer('isASC');
            $table->string('user')->default('admin');
            $table->string('source')->default('Источник');
            $table->set('flags', [
                '0',
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
            ])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_points');
    }
};
