<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|unique:statuses,status',
        ], [
            'status.unique' => 'Status already exists.',
        ]);

        $status = new Status();
        $status->status = $validatedData['status'];
        $status->save();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Status added successfully!');
    }

    public function index() {
        $statuses = Status::orderBy('status', 'asc')->paginate(10);

        return view('fcu-ams/statuses/statusesList', compact('statuses'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        $status = Status::findOrFail($id);
        $status->status = $validatedData['status'];
        $status->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function destroy($id)
    {
        $status = Status::findOrFail($id);

        $status = Status::find($id);
        if ($status) {
            try {
                $status->delete();
                return redirect()->back()->with('success', 'Status deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors(['error' => 'Cannot delete status because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Status not found']);
        }
    }

    public function list()
    {
        return response()->json(Status::orderBy('status', 'asc')->get());
    }
}
