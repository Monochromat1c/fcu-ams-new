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
}
