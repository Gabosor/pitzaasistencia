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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('ci')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fechaIng');
            $table->string('rol')->default('empleado');
            $table->decimal('SalarioBase', 10, 2)->default(0);
            $table->string('telefono')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
