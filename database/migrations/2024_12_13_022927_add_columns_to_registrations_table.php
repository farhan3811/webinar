<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Menambahkan kolom baru dengan nullable
            $table->string('kode_unik')->nullable()->after('id');
            $table->string('pendamping')->nullable()->after('kode_unik');
            $table->string('seat_number')->nullable()->after('pendamping');
            $table->date('check_in_date')->nullable()->after('seat_number');
            $table->boolean('checked_in')->nullable()->default(null)->after('check_in_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Menghapus kolom yang telah ditambahkan
            $table->dropColumn(['kode_unik', 'pendamping', 'seat_number', 'check_in_date', 'checked_in']);
        });
    }
};
