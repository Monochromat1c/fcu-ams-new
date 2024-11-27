<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Inventory;
use App\Models\Department;
use App\Models\AssetEditHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        return view('fcu-ams/profile/profile', compact('user'));
    }

    public function update(Request $request) {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string',
            'confirm_new_password' => 'required|string|same:new_password',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }

    public function updatePersonalInformation(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        $user = auth()->user();
        $nameParts = explode(' ', $request->input('full_name'));

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && file_exists(public_path($user->profile_picture)) && basename($user->profile_picture) != 'mele.png') {
                unlink(public_path($user->profile_picture));
            }

            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile'), $imageName);
            $user->profile_picture = 'profile/' . $imageName;
        }

        if (count($nameParts) === 2) {
            $user->first_name = $nameParts[0];
            $user->middle_name = null;
            $user->last_name = $nameParts[1];
        } elseif (count($nameParts) >= 3) {
            $user->first_name = $nameParts[0];
            $user->middle_name = $nameParts[1];
            $user->last_name = implode(' ', array_slice($nameParts, 2));
        } else {
            return back()->withErrors(['full_name' => 'Please provide a valid full name.']);
        }

        $user->email = $request->input('email');
        $user->contact_number = $request->input('contact_number');
        $user->address = $request->input('address');
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
