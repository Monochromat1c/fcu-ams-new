<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index() {
        $users = User::with('role')->orderBy('first_name', 'asc')->paginate(10);
        $roles = Role::all();

        return view('fcu-ams/users/usersList', compact('users', 'roles'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
        ]);

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->contact_number = $request->input('contact_number');
        $user->role_id = $request->input('role_id');
        $user->department_id = $request->input('department_id');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));

        if ($request->hasFile('profile_picture')) {
            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile'), $imageName);
            $user->profile_picture = 'profile/'.$imageName;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|string|unique:users,username,'.$id,
        ]);

        $user = User::find($id);
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->contact_number = $request->input('contact_number');
        $user->role_id = $request->input('role_id');
        $user->department_id = $request->input('department_id');
        $user->email = $request->input('email');
        $user->username = $request->input('username');

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && 
                file_exists(public_path($user->profile_picture)) && 
                !in_array(basename($user->profile_picture), ['mele.png', 'liling.jpg', '1728809102.jpg', 'defaultProfile.png'])) {
                unlink(public_path($user->profile_picture));
            }
            
            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile'), $imageName);
            $user->profile_picture = 'profile/'.$imageName;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->profile_picture) {
            unlink(public_path($user->profile_picture));
        }

        try {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('user.index')->withErrors(['error' => 'Cannot delete user because it is associated with other data.']);
        }
    }

    public function signup(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->contact_number = $request->input('contact_number');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->department_id = $request->input('department_id');

        $departmentRole = Role::where('role', 'Department')->first();
        if ($departmentRole) {
            $user->role_id = $departmentRole->id;
        }

        if ($request->hasFile('profile_picture')) {
            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile'), $imageName);
            $user->profile_picture = 'profile/'.$imageName;
        }

        $user->save();

        return redirect()->route('signup')->with('success', 'User created successfully!');
    }
}
