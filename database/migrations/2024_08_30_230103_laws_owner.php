<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('laws', function (Blueprint $table) {
            $table->foreignId('law_owner_user_id')->after('law_image')
                ->nullable(true)->constrained('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laws', function (Blueprint $table) {
            $table->dropForeign(['law_owner_user_id']);
        });
    }
};
