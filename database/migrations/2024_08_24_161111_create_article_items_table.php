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
        Schema::create('article_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_title');
            $table->text('item_description');
            $table->text('item_comment')->nullable();
            $table->boolean('item_is_informative')->default(false);
            $table->boolean('item_is_complete')->default(false);
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_items');
    }
};
