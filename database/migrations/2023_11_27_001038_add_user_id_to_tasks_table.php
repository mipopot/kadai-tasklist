<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 1. user_idカラムを追加（整数として）
            $table->unsignedBigInteger('user_id');

            // 2. 外部キー制約を追加
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 1. 外部キー制約の削除
            $table->dropForeign(['user_id']);

            // 2. user_idカラムを削除
            $table->dropForeign('user_id');
        });
    }
};
