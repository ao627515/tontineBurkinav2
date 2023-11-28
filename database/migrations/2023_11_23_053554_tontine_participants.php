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
        Schema::create('tontine_participants', function (Blueprint $table) {
            $table->foreignUuid('participant_id');
            $table->foreignUuid('tontine_id');
            $table->integer('assigned_rank')->default(1);
            $table->integer('occupied_places')->default(1);
            $table->timestamp('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
