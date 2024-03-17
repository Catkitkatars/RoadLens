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
        Schema::create('russia', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('country');
            $table->string('region');
            $table->string('type');
            $table->string('model');
            $table->string('camera_latitude');
            $table->string('camera_longitude');
            $table->string('target_latitude');
            $table->string('target_longitude');
            $table->string('direction');
            $table->string('distance');
            $table->string('angle');
            $table->string('car_speed');
            $table->string('truck_speed');
            $table->string('isDeleted')->default('0');
            $table->string('user')->default('admin');
            $table->string('source');
            $table->set('flags', [
                '1', 
                '2', 
                '3',
                '4', 
                '5', 
                '6',
                '7', 
                '8', 
                '9',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('russia');
    }
};
