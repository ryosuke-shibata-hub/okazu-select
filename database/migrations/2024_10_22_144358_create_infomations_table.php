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
        Schema::create('infomations', function (Blueprint $table) {
            $table->id();
            $table->text('title')->comment('お知らせのタイトル');
            $table->text('detail')->comment('お知らせの内容');
            $table->integer('category')->comment('お知らせのカテゴリ');
            $table->integer('delete_flg')->comment('削除フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infomations');
    }
};
