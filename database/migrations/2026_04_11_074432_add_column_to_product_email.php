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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('otp_feature')->default(false);
            $table->integer('akun_gmail_id')->default(0);
            $table->integer('get_only_subject')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('otp_feature');
            $table->dropColumn('akun_gmail_id');
            $table->dropColumn('get_only_subject');
        });
    }
};
