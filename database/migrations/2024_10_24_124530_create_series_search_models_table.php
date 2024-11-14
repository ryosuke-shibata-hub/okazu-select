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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->integer('series_id')->comment('シリーズID');
            $table->text('site_name')->comment('サイト名');
            $table->text('site_code')->comment('サイトコード');
            $table->text('service_name')->comment('サービス名');
            $table->text('service_code')->comment('サービスコード');
            $table->integer('floor_id')->comment('フロアID');
            $table->text('floor_name')->comment('フロア名');
            $table->text('floor_code')->comment('フロアコード');
            $table->text('series_name')->comment('シリーズ名');
            $table->text('series_name_ruby')->comment('ルビ');
            $table->text('list_url')->comment('シリーズurl');
            $table->integer('delete_flg')->comment('削除フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};