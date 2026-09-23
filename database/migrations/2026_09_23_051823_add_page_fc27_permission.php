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
        $permission = \Spatie\Permission\Models\Permission::firstOrCreate([
            'name' => 'page_FC2027',
            'guard_name' => 'web',
        ]);

        $superAdmin = \Spatie\Permission\Models\Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo($permission);
        }

        $panelUser = \Spatie\Permission\Models\Role::where('name', 'panel_user')->first();
        if ($panelUser) {
            $panelUser->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permission = \Spatie\Permission\Models\Permission::where('name', 'page_FC2027')->where('guard_name', 'web')->first();
        if ($permission) {
            $permission->delete();
        }
    }
};
