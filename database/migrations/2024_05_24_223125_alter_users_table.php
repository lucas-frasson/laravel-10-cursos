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
        Schema::table('users', function (Blueprint $table){
            // Adicionar tipo após email
            $table->enum('type', ['cliente', 'admin'])->default('cliente')->after('email');

            // Adicionar deleted_at após updated_at
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('type');
            $table->dropSoftDeletes('');
        });
    }
};
