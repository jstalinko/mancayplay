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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('license_fc25')->default(false);
            $table->boolean('license_fc26')->default(false);
            $table->integer('generate_token_quota')->default(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',function (Blueprint $table) {
            $table->dropColumn('license_fc25');
            $table->dropColumn('license_fc26');
            $table->dropColumn('generate_token_quota');
        });
    }
};
