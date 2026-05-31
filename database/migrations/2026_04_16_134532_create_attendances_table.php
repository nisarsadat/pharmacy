<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // ذخیره به میلادی (صحیح)
            $table->date('date');

            $table->enum('status', ['present', 'absent', 'leave']);

            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            // جلوگیری از تکرار
            $table->unique(['employee_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};