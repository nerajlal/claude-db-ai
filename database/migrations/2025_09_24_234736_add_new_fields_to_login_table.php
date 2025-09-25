<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('login', function (Blueprint $table) {
            if (!Schema::hasColumn('login', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('login', 'firstname')) {
                $table->string('firstname')->after('name');
            }
            if (!Schema::hasColumn('login', 'lastname')) {
                $table->string('lastname')->after('firstname');
            }
            if (!Schema::hasColumn('login', 'status')) {
                $table->tinyInteger('status')->default(0)->after('password');
            }
            if (!Schema::hasColumn('login', 'plan')) {
                $table->tinyInteger('plan')->default(1)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login', function (Blueprint $table) {
            if (Schema::hasColumn('login', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('login', 'firstname')) {
                $table->dropColumn('firstname');
            }
            if (Schema::hasColumn('login', 'lastname')) {
                $table->dropColumn('lastname');
            }
            if (Schema::hasColumn('login', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('login', 'plan')) {
                $table->dropColumn('plan');
            }
        });
    }
};