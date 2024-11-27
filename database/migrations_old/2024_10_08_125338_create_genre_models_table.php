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
        Schema::create('genre', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('genre_id')->unique()->comment('ジャンルID');
            $table->integer('floor_id')->comment('フロアID');
            $table->text('genre_name')->comment('ジャンル名');
            $table->text('genre_name_ruby')->comment('ジャンル名（ルビあり）');
            $table->text('list_url')->comment('リストページURL（アフィリエイトID付き）');
            $table->integer('delete_flg')->comment('削除フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre');
    }
};
