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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 300);
            $table->integer('sks');
            $table->integer('number_of_meetings')->default(16);
            // $table->foreignId("child_id")->nullable()->constrained("structures")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("class_id")->nullable()->constrained("classes")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("semester_id")->nullable()->constrained("semesters")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("sdm_id")->nullable()->constrained("human_resources")->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};
