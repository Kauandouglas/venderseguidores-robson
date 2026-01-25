<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('sync_price')->default(false)->after('dynamic_pricing');
            $table->decimal('sync_margin_percent', 8, 2)->default(0)->after('sync_price');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['sync_price', 'sync_margin_percent']);
        });
    }
};
