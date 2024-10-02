<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'site' => 'required|string',
        ]);

        $site = new Site();
        $site->site = $validatedData['site'];
        $site->save();

        $request->session()->put('input', $request->all());

        return response()->json(['reload' => true]);
    }
}
