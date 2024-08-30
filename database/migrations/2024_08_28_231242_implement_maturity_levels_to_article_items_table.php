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
        Schema::table('article_items', function (Blueprint $table) {
            $table->dropColumn('item_is_complete');
            $table->foreignId('maturity_id')->after('item_is_informative')->constrained('maturity_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_items', function (Blueprint $table) {
            $table->dropForeign(['maturity_id']);
            $table->boolean('item_is_complete')->default(false);
        });
    }
};
