<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('keyword')->nullable();

            // Logo
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            // Layout
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->boolean('color_default')->default(0);

            // Terms
            $table->text('terms')->nullable();

            // Code
            $table->text('code')->nullable();

            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
}
