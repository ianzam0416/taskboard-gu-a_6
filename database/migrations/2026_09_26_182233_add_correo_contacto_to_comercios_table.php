<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comercios', function (Blueprint $table) {
            $table->string('correo_contacto')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('comercios', function (Blueprint $table) {
            $table->dropColumn('correo_contacto');
        });
    }
};