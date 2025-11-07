<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint; /* subclase de Schema */
use Illuminate\Support\Facades\Schema; /* clase Shcema */

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) { /* crea una tabla y sus propiedades */
            $table->id(); 
            $table->string('name');
            $table->string('email')->unique(); /* metodo que indica que no puede haber dos iguales */
            $table->timestamp('email_verified_at')->nullable(); /* permite valores nulos */
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) { /* crea una tabla y sus propiedades */
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable(); /* permite valores nulos */
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    { /* es importante en el orden en que están creados, para que no elimine unas tablas antes de otras. Va en orden inverso a la creación */
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
