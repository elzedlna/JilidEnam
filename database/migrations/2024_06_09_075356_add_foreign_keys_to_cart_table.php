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
        Schema::table('cart', function (Blueprint $table) {
           // $table->foreign('custid')->references('id')->on('users');
           // $table->foreign('menuitemid')->references('menuid')->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
           // $table->dropForeign(['custid']);
           // $table->dropForeign(['menuitemid']);
        });
    }
};
