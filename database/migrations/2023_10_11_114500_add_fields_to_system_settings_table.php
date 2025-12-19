<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->boolean('notify_popup_status')->after('email')->default(0);
            $table->string('notify_popup_title')->after('notify_popup_status')->nullable();
            $table->text('notify_popup_description')->after('notify_popup_title')->nullable();
            $table->text('notify_popup_url')->after('notify_popup_description')->nullable();
            $table->string('notify_popup_button_name')->after('notify_popup_url')->nullable();
            $table->string('notify_popup_button_color')->after('notify_popup_button_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropColumn(['notify_popup_status', 'notify_popup_title', 'notify_popup_description', 'notify_popup_url', 'notify_popup_button_name', 'notify_popup_button_color']);
        });
    }
}
