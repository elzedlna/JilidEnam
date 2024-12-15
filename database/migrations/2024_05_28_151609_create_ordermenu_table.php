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
        // Drop the table if it exists
        Schema::dropIfExists('ordermenu');

        // Now create the table
        Schema::create('ordermenu', function (Blueprint $table) {
            $table->increments('ordermenuid')->primary();
            $table->integer('quantity');
            $table->date('orderdate');
            $table->time('ordertime');
            $table->string('ordermethod');
            $table->decimal('totalbill', 8,2);
            $table->char('menuid', 4);
            $table->string('menuname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordermenu');
    }
};
