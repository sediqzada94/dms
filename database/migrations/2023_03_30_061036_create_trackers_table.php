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
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
            $table->bigInteger('in_num');
            $table->bigInteger('out_num');
            $table->date('in_date');
            $table->date('out_date');
            $table->smallInteger('request_deadline');
            $table->text('remark');
            $table->smallInteger('attachment_count');
            $table->foreignId('deadline_id')->constrained()->nullable();
            $table->foreignId('status_id')->constrained()->nullable();
            $table->foreignId('deadline_type_id')->constrained()->nullable();
            $table->foreignId('security_level_id')->constrained()->nullable();
            $table->foreignId('followup_type_id')->constrained()->nullable();
            $table->foreignId('document_id')->constrained()->nullable()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('doc_type_id')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackers');
    }
};
