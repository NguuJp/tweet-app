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
        Schema::table('tweets', function (Blueprint $table) {
            $table->unsignedBigInteger('original_tweet_id')->nullable()->after('body'); // original_tweet_idカラムを追加

            // tweetsテーブルのidカラムにoriginal_tweet_idカラムを関連付けます
            $table->foreign('original_tweet_id')->references('id')->on('tweets')->onDelete('cascade'); // 外部キー制約
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tweets', function (Blueprint $table) {
            // original_tweet_idカラムを削除
            $table->dropForeign(['original_tweet_id']); // 外部キー制約を削除
            $table->dropColumn('original_tweet_id'); // original_tweet_idカラムを削除
        });
    }
};
