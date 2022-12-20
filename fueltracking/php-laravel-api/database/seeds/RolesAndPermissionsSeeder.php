<?php
use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
	private $permissionsByRole = [
			
		'super admin' => [
			'home/list', 'kategori/list', 'kategori/view', 'kategori/add', 'kategori/edit', 'kategori/delete', 'kategori/importdata', 'model_has_permissions/list', 'model_has_permissions/view', 'model_has_permissions/add', 'model_has_permissions/edit', 'model_has_permissions/delete', 'model_has_permissions/importdata', 'model_has_roles/list', 'model_has_roles/view', 'model_has_roles/add', 'model_has_roles/edit', 'model_has_roles/delete', 'model_has_roles/importdata', 'pengajuan/list', 'pengajuan/view', 'pengajuan/add', 'pengajuan/edit', 'pengajuan/delete', 'pengajuan/importdata', 'permissions/list', 'permissions/view', 'permissions/add', 'permissions/edit', 'permissions/delete', 'permissions/importdata', 'role_has_permissions/list', 'role_has_permissions/view', 'role_has_permissions/add', 'role_has_permissions/edit', 'role_has_permissions/delete', 'role_has_permissions/importdata', 'roles/list', 'roles/view', 'roles/add', 'roles/edit', 'roles/delete', 'roles/importdata', 'tb_bahanbakar/list', 'tb_bahanbakar/view', 'tb_bahanbakar/add', 'tb_bahanbakar/edit', 'tb_bahanbakar/delete', 'tb_bahanbakar/importdata', 'users/list', 'users/view', 'users/add', 'users/edit', 'users/delete', 'users/importdata', 'voucher/list', 'voucher/view', 'voucher/add', 'voucher/edit', 'voucher/delete', 'voucher/importdata', 'account/list', 'account/edit', 'track/list', 'track/view', 'track/add', 'track/edit', 'track/delete'
		], 
		'fdo' => [
			'home/list', 'pengajuan/list', 'pengajuan/view', 'pengajuan/edit', 'pengajuan/importdata', 'voucher/list', 'voucher/view', 'voucher/importdata', 'account/list', 'account/edit', 'track/list', 'track/view', 'track/add', 'track/edit', 'track/delete'
		], 
		'drivers' => [
			'pengajuan/list', 'pengajuan/view', 'pengajuan/add', 'pengajuan/edit', 'voucher/list', 'voucher/add', 'voucher/importdata', 'account/list', 'account/edit'
		], 
		'finance' => [
			'home/list', 'voucher/list', 'voucher/view', 'account/list'
		], 
		'admin spbu' => [
			'home/list', 'voucher/list', 'voucher/view', 'track/list', 'track/view', 'track/add', 'track/edit', 'track/delete'
		]
	];
    public function run()
    {
        $tableNames = config('permission.table_names');

		Schema::disableForeignKeyConstraints();

		DB::table($tableNames['role_has_permissions'])->truncate();
		DB::table($tableNames['permissions'])->truncate();
        DB::table($tableNames['roles'])->truncate();

		Schema::enableForeignKeyConstraints();
		
		app()['cache']->forget('spatie.permission.cache');
		app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

		$this->syncPermissions();
		$this->syncRoles();
		$this->syncUsersRole('drivers');
    }
	function syncRoles(){
		foreach ($this->permissionsByRole as $rolename => $permissions) {
			$role = Role::create(['name' => $rolename]);
			$role->givePermissionTo($permissions);
		}
	}

	function syncPermissions(){
		$permissions = [];

		foreach ($this->permissionsByRole as $rolename => $rolePermissions) {
			$permissions = array_merge($permissions, $rolePermissions);
		}

		$insertData = [];
		foreach($permissions as $name){
			$insertData[] = ['name'=>$name, 'guard_name' => 'web'];
		}
		Permission::insert($insertData);
	}

	function syncUsersRole($role){
		$users = Users::all();
		foreach($users as $user){
			$user->syncRoles($role);
		}
	}
}
