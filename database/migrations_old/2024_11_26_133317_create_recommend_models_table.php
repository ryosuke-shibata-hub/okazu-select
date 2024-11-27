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
        Schema::create('recommend', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail')->comment('サムネ画像');
            $table->string('title')->comment('作品タイトル');
            $table->text('detail')->comment('作品紹介記事');
            $table->integer('view_count')->comment('閲覧数');
            $table->integer('delete_flg')->comment('削除フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommend');
    }
};
