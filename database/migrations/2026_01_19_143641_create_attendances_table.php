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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();

        // ユーザーID（users.id）
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // 勤怠日（1ユーザー1日1レコード用）
        $table->date('date');

        // 出勤・退勤時刻
        $table->dateTime('clock_in_at')->nullable();
        $table->dateTime('clock_out_at')->nullable();

        // 1ユーザー1日1レコード制約
        $table->unique(['user_id', 'date']);

        // 管理用
        $table->timestamps();
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
