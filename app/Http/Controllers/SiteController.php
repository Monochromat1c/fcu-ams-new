<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'site' => 'required|string|unique:sites,site',
        ], [
            'site.unique' => 'Site already exists.',
        ]);

        $site = new Site();
        $site->site = $validatedData['site'];
        $site->save();

        return redirect()->route('site.index')->with('success', 'Site added successfully!');
    }

    public function index() {
        $sites = Site::orderBy('site', 'asc')->paginate(10);

        return view('fcu-ams/sites/sitesList', compact('sites'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'site' => 'required|string',
        ]);

        $site = Site::findOrFail($id);
        $site->site = $validatedData['site'];
        $site->save();

        return redirect()->route('site.index')->with('success', 'Site updated successfully!');
    }

    public function destroy($id)
    {
        $site = Site::findOrFail($id);

        $site = Site::find($id);
        if ($site) {
            try {
                $site->delete();
                return redirect()->route('site.index')->with('success', 'Site deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->route('site.index')->withErrors(['error' => 'Cannot delete site because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Site not found']);
        }
    }
}
