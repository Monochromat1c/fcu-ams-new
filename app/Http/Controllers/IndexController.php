<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class IndexController extends Controller
{
    public function testForm() {
        $roles = Role::all();
        return view ('fcu-ams/test-form', compact('roles'));
    }
}
