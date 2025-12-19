<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();

            // Nav
            $table->string('nav_button')->nullable();

            // Header
            $table->string('header_title')->nullable();
            $table->text('header_sub_title')->nullable();
            $table->string('header_button')->nullable();
            $table->string('header_image')->nullable();

            // Service
            $table->string('service_image_1')->nullable();
            $table->string('service_title_1')->nullable();
            $table->text('service_sub_title_1')->nullable();
            $table->text('service_description_1')->nullable();
            $table->string('service_image_2')->nullable();
            $table->string('service_title_2')->nullable();
            $table->text('service_sub_title_2')->nullable();
            $table->text('service_description_2')->nullable();
            $table->string('service_image_3')->nullable();
            $table->string('service_title_3')->nullable();
            $table->text('service_sub_title_3')->nullable();
            $table->text('service_description_3')->nullable();

            // About
            $table->string('about_image')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_button')->nullable();

            // Basic
            $table->string('basic_title')->nullable();
            $table->text('basic_description')->nullable();

            // Contact
            $table->string('contact_title')->nullable();
            $table->text('contact_description')->nullable();

            // Footer
            $table->string('footer_title')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('config_templates');
    }
}
