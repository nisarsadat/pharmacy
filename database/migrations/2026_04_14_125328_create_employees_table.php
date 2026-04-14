<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id();

        $table->string('image')->nullable();
        $table->string('name');
        $table->string('father_name');
        $table->string('last_name')->nullable();

        $table->string('tazkira_number')->nullable()->unique();

        $table->string('phone_number');
        $table->string('whatsapp_number');

        $table->enum('gender', ['male', 'female'])->nullable();

        $table->time('shift_from');
        $table->time('shift_to');

        $table->decimal('salary_amount', 10, 2)->default(0);
        $table->decimal('salary_amount_per_day', 10, 2);

        $table->string('job_type')->nullable();

        $table->date('entry_date')->nullable();
        $table->date('leave_date')->nullable();

        $table->integer('work_days');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
