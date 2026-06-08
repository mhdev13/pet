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
        Schema::table('pets', function (Blueprint $table) {
            $table->date('flea_medicine_date')->nullable()->after('weight');
            $table->date('deworming_date')->nullable()->after('flea_medicine_date');
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['flea_medicine_date', 'deworming_date']);
        });
    }
};
