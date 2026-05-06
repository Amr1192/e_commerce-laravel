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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('categoreis');
    
    }
};


// make migration creates file that has the structure of the table

//php artisan migrate       excutes the up funciton

// php artisan migrate     excutes the up funciton

//php artisan migration:rollback        rollback final migration


//migrate:fresh   drops all table   then run the migrations


//migrate:refresh   run all down functions  then run the migrations


//migrate:reset     runs all down function.
