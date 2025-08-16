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
        Schema::create('unrecognized_faces', function (Blueprint $table) {
            $table->id()->comment('رقم تسلسلي');
            $table->enum('category', ['ENTER', 'LEAVE'])->comment('النوع: دخول أم خروج');
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('تاريخ الإنشاء');
        });
        DB::statement("ALTER TABLE unrecognized_faces ADD snapshot MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unrecognized_faces');
    }
};
