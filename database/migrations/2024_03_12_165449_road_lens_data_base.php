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
            $table->char('ulid', 26)->unique();
            $table->integer('country');
            $table->integer('region');
            $table->integer('type');
            $table->integer('model');
            $table->float('camera_latitude', 8, 6);
            $table->float('camera_longitude', 8, 6);
            $table->float('target_latitude', 8, 6);
            $table->float('target_longitude', 8, 6);
            $table->integer('direction');
            $table->integer('distance');
            $table->integer('angle');
            $table->integer('car_speed');
            $table->integer('truck_speed');
            $table->integer('isDeleted')->default('0');
            $table->integer('isASC');
            $table->string('user')->default('admin');
            $table->string('source');
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
                '9',
                '10'
            ])->default('0');
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
