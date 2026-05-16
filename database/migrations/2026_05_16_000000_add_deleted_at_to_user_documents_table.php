<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user_documents')) {
            return;
        }

        if (!Schema::hasColumn('user_documents', 'deleted_at')) {
            Schema::table('user_documents', function (Blueprint $table) {
                $table->softDeletes()->after('document')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('user_documents')) {
            return;
        }

        if (Schema::hasColumn('user_documents', 'deleted_at')) {
            Schema::table('user_documents', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
