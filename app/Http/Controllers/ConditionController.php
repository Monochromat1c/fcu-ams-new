<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'condition' => 'required|string|unique:conditions,condition',
        ], [
            'condition.unique' => 'Condition already exists.',
        ]);

        $condition = new Condition();
        $condition->condition = $validatedData['condition'];
        $condition->save();

        return redirect()->route('condition.index')->with('success', 'Condition added successfully!');
    }

    public function index() {
        $conditions = Condition::orderBy('condition', 'asc')->paginate(10);

        return view('fcu-ams/conditions/conditionsList', compact('conditions'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'condition' => 'required|string',
        ]);

        $condition = Condition::findOrFail($id);
        $condition->condition = $validatedData['condition'];
        $condition->save();

        return redirect()->route('condition.index')->with('success', 'Condition updated successfully!');
    }

    public function destroy($id)
    {
        $condition = Condition::findOrFail($id);

        $condition = Condition::find($id);
        if ($condition) {
            try {
                $condition->delete();
                return redirect()->route('condition.index')->with('success', 'Condition deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->route('condition.index')->withErrors(['error' => 'Cannot delete condition because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Condition not found']);
        }
    }
}
