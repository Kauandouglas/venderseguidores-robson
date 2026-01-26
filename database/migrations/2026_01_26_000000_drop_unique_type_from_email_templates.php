<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueTypeFromEmailTemplates extends Migration
{
    /**
     * Run the migrations.
     * Remove the global unique constraint on `type` so each user can have their own templates.
     */
    public function up(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            // Remove the single-column unique index that blocks per-user templates
            $table->dropUnique('email_templates_type_unique');
            // Composite unique (user_id, type) already exists from the original migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            // Restore the single-column unique constraint if needed
            $table->unique('type');
        });
    }
}
