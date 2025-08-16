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
        Schema::create('faces', function (Blueprint $table) {
            $table->id()->comment('رقم تسلسلي');
            $table->string('ref_no')->unique()->comment('رقم مرجعي فريد');
            $table->string('name', 50)->comment('اسم الشخصية');
            $table->date('date_of_birth');
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE faces ADD data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faces');
    }
};
