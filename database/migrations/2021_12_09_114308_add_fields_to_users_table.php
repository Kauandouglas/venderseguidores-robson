<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('domain')->nullable()->unique()->after('name');
            $table->string('image')->nullable()->after('domain');
            $table->integer('role')->default(2)->after('image');
            $table->boolean('status')->default(1)->after('role');
            $table->string('phone')->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['image', 'role', 'phone']);
        });
    }
}
