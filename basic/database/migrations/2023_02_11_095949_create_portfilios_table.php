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
        Schema::create('portfilios', function (Blueprint $table) {
            $table->id();
            $table->string('portfilio_name')->nullable();
            $table->string('portfilio_title')->nullable();
            $table->string('portfilio_image')->nullable();
            $table->text('portfilio_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfilios');
    }
};
