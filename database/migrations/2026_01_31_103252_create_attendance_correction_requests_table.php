<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendance_correction_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attendance_id')->constrained()->cascadeOnDelete();

            $table->dateTime('requested_clock_in_at')->nullable();
            $table->dateTime('requested_clock_out_at')->nullable();

            $table->text('reason');

            $table->string('status')->default('pending'); // pending / approved / rejected
            $table->dateTime('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_correction_requests');
    }
};
