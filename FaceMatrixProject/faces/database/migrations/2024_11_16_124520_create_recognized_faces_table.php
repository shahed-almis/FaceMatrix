<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recognized_faces', function (Blueprint $table) {
            $table->id()->comment('رقم تسلسلي');
            $table->unsignedBigInteger('face_id')->comment('رابط سجل الوجه');
            $table->enum('category', ['ENTER', 'LEAVE'])->nullable()->comment('التصنيف: دخول أم خروج');
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('تاريخ الإنشاء');
            $table->foreign('face_id')->references('id')->on('faces')->onDelete('cascade')->onUpdate('cascade');
        });
        DB::statement("ALTER TABLE recognized_faces ADD snapshot MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recognized_faces');
    }
};
