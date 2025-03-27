<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Models\Roles;
use App\Models\Admin;
use App\Models\User;
use Auth;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = User::with('roles')->orderBy('id', 'DESC')->paginate(5);
        $roles = Roles::orderBy('id', 'DESC')->get();
        return view('admin.users.all_users')->with(compact('admin', 'roles'));;
    }

    public function add_users()
    {
        return view('admin.users.add_users');
    }
    public function delete_user_roles($admin_id)
    {
        if (User::find($admin_id)) {
            return redirect()->back()->with('message', 'Bạn không được quyền xóa chính mình');
        }
        $admin = User::find($admin_id);

        if ($admin) {
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message', 'Xóa user thành công');
    }
    public function assign_roles(Request $request)
    {
        // Prevent assigning roles to the current authenticated user
        if (User::find($request->admin_id)) {
            return redirect()->back()->with('message', 'Bạn không được phân quyền chính mình');
        }

        // Fetch the user by email
        $user = User::where('email', $request->admin_email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Detach existing roles
        $user->roles()->detach();

        // Attach new roles dynamically based on the submitted checkboxes
        if ($request->has('roles')) {
            foreach ($request->roles as $role) {
                $roleModel = Roles::where('name', $role)->first();
                if ($roleModel) {
                    $user->roles()->attach($roleModel);
                }
            }
        }

        return redirect()->back()->with('message', 'Cấp quyền thành công');
    }

    public function store_users(Request $request)
    {
        $data = $request->all();
        $admin = new User();
        $admin->name = $data['admin_name'];
        $admin->phone = $data['admin_phone'];
        $admin->email = $data['admin_email'];
        $admin->password = md5($data['admin_password']);
        $admin->roles()->attach(Roles::where('name', 'user')->first());
        $admin->save();
        Session::put('message', 'Thêm users thành công');
        return Redirect::to('users');
    }
}
