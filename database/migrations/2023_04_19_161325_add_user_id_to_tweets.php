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
            // ログインユーザー情報をtweetsテーブルに追加
            $table->unsignedBigInteger('user_id')->after('id'); // user_idカラムを追加

            // userテーブルのidカラムにuser_idカラムを関連付けます
            $table->foreign('user_id')->references('id')->on('users'); // 外部キー制約
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tweets', function (Blueprint $table) {
            // ログインユーザー情報をtweetsテーブルから削除
            $table->dropForeign(['user_id']); // 外部キー制約を削除
            $table->dropColumn('user_id'); // user_idカラムを削除
        });
    }
};
