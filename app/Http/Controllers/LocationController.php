<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'location' => 'required|string|unique:locations,location',
        ], [
            'location.unique' => 'Location already exists.',
        ]);

        $location = new Location();
        $location->location = $validatedData['location'];
        $location->save();

        return redirect()->back()->with('success', 'Location added successfully!');
    }

    public function index() {
        $locations = Location::orderBy('location', 'asc')->paginate(10);

        return view('fcu-ams/locations/locationsList', compact('locations'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'location' => 'required|string',
        ]);

        $location = Location::findOrFail($id);
        $location->location = $validatedData['location'];
        $location->save();

        return redirect()->back()->with('success', 'Location updated successfully!');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        $location = Location::find($id);
        if ($location) {
            try {
                $location->delete();
                return redirect()->back()->with('success', 'Location deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors(['error' => 'Cannot delete location because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Location not found']);
        }
    }
}
