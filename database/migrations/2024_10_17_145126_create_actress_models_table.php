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
        Schema::create('actress', function (Blueprint $table) {
            $table->bigInteger('actress_id')->unique()->comment('女優ID');
            $table->text('actress_name')->comment('女優名');
            $table->text('actress_ruby')->comment('女優名(ルビ)');
            $table->text('actress_bust')->comment('バスタサイズ');
            $table->text('actress_cup')->comment('カップ数');
            $table->text('actress_waist')->comment('ウエストサイズ');
            $table->text('actress_hip')->comment('ヒップサイズ');
            $table->text('actress_height')->comment('身長');
            $table->text('actress_birthday')->comment('生年月日');
            $table->text('actress_blood_type')->comment('血液型');
            $table->text('actress_hobby')->comment('趣味');
            $table->text('actress_prefectures')->comment('出身地');
            $table->text('imageURL')->comment('イメージ画像');
            $table->text('digital')->comment('動画');
            $table->text('monthly_premium')->comment('月額動画');
            $table->text('mono')->comment('通販');
            $table->integer('delete_flg')->comment('削除フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actress');
    }
};
