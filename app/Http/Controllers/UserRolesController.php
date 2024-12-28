<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Session;
use Auth;
use Artisan;

class UserRolesController extends Controller
{
	// public function __construct()
	// {

	// 	$this->middleware('permission:list user', ['only' => ['index']]);
	// }
	public function AuthLogin()
	{

		// if (Session::get('login_normal')) {

		// 	$admin_id = Session::get('admin_id');
		// } else {
		// 	$admin_id = Auth::id();
		// }
		// if ($admin_id) {
		// 	return Redirect::to('dashboard');
		// } else {
		// 	return Redirect::to('admin')->send();
		// }
	}
	public function create($admin_id)
	{
		$this->AuthLogin();
		$roles = Role::all();

		$user = User::find($admin_id);
		$user_roles = $user->roles->first();
		return view('admin.roles.create_role', compact('user', 'roles', 'user_roles'));
	}
	public function create_permission($admin_id)
	{
		$this->AuthLogin();
		$permission = Permission::all();
		$user = User::find($admin_id);
		$name_roles = $user->roles->first()->name;
		$pers_role = $user->getPermissionsViaRoles();
		return view('admin.roles.create_permission', compact('user', 'name_roles', 'permission', 'pers_role'));
	}
	public function assign_permission($admin_id, Request $request)
	{
		$this->AuthLogin();
		$data =  $request->all();
		$user = User::find($admin_id);
		$role_id = $user->roles->first()->id;
		$role = Role::find($role_id);
		$role->syncPermissions($data['permission']);

		// dd($data['permission']);
		return redirect()->back()->with('message', 'Thêm quyền user thành công');
	}
	public function index()
	{
		$this->AuthLogin();
		Artisan::call('cache:clear');
		$user = User::with('roles', 'permissions')->orderby('id', 'desc')->get();
		// dd($user);
		return view('admin.roles.index', compact('user'));
	}

	public function assign_role($admin_id, Request $request)
	{
		$this->AuthLogin();
		$data =  $request->all();

		$admin = User::find($admin_id);
		$admin->syncRoles($data['role']);
		return redirect()->back()->with('message', 'Thêm vai trò user thành công');
	}
}
