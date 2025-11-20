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
        Schema::table('participants', function (Blueprint $table) {
            //Rimuovo unique dalla colonna email
            $table->dropUnique('participants_email_unique');

            //Aggiungo nuovo unique
            $table->unique(['secret_santa_id', 'email'], 'participants_santa_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropUnique('participants_santa_email_unique');

            $table->unique('email', 'participants_email_unique');
        });
    }
};
