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

        $viewerRole = Role::where('role', 'Viewer')->first();
        if ($viewerRole) {
            $user->role_id = $viewerRole->id;
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
