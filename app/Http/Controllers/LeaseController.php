<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use DB;
use App\Models\Lease;
use App\Models\Status;
use App\Models\LeaseItem;

class LeaseController extends Controller
{
    public function index(Request $request)
    {
        $this->removeExpiredLeases();
        $search = $request->input('search');

        $leases = Lease::with('assets')->orderBy('id', 'desc');

        if ($search) {
            $leases = $leases->where(function ($q) use ($search) {
                $q->where('leases.id', 'like', '%' . $search . '%')
                    ->orWhere('leases.lease_date', 'like', '%' . $search . '%')
                    ->orWhere('leases.lease_expiration', 'like', '%' . $search . '%')
                    ->orWhere('leases.customer', 'like', '%' . $search . '%')
                    ->orWhere('leases.contact_number', 'like', '%' . $search . '%')
                    ->orWhere('leases.email', 'like', '%' . $search . '%')
                    ->orWhereHas('assets', function ($q) use ($search) {
                        $q->where('assets.asset_tag_id', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->input('clear') == 'true') {
            return redirect()->route('lease.index');
        }

        $leases = $leases->paginate(15);

        return view('fcu-ams/lease/lease', compact('leases'));
    }

    private function removeExpiredLeases()
    {
        $leases = Lease::where('lease_expiration', '<', now())->get();

        foreach ($leases as $lease) {
            foreach ($lease->assets as $asset) {
                $asset->updateStatusToAvailable();
                $asset->updateConditionToUsed();
            }

            $lease->delete();
        }
    }

    public function create()
    {
        $assets = Asset::whereNull('deleted_at')
            ->whereHas('status', function ($query) {
                $query->where('status', 'Available');
            })
            ->orderBy('asset_tag_id', 'asc')
            ->get();
        return view('fcu-ams/lease/selectAssets', compact('assets'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'lease_date' => 'required|date',
            'lease_expiration' => 'required|date|after:lease_date',
            'customer' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'note' => 'nullable|string',
            'selected_assets' => 'required|array|min:1',
        ]);

        $lease = new Lease();
        $lease->lease_date = $request->input('lease_date');
        $lease->lease_expiration = $request->input('lease_expiration');
        $lease->customer = $request->input('customer');
        $lease->contact_number = $request->input('contact_number');
        $lease->email = $request->input('email');
        $lease->note = $request->input('note') ?? null;
        $lease->save();

        $selectedAssets = $request->input('selected_assets');
        if ($selectedAssets) {
            foreach ($selectedAssets as $assetId) {
                $leaseItem = new LeaseItem();
                $leaseItem->lease_id = $lease->id;
                $leaseItem->asset_id = $assetId;
                $leaseItem->save();

                $asset = Asset::find($assetId);
                $asset->updateStatusToLeased();
            }
        }

        return redirect()->route('lease.index')->with('success', 'Lease created successfully.');
    }

    public function createForm(Request $request)
    {
        $this->validate($request, [
            'selected_assets' => 'required|array|min:1',
        ], [
            'selected_assets.required' => 'Please select at least one asset.',
        ]);

        $selectedAssets = $request->input('selected_assets');
        if ($selectedAssets) {
            $assets = Asset::whereIn('id', $selectedAssets)->get();
            return view('fcu-ams/lease/leaseForm', compact('assets', 'selectedAssets'));
        } else {
            return view('fcu-ams/lease/leaseForm')->with('error', 'Please select at least one asset.');
        }
    }

    public function show($id)
    {
        $lease = Lease::findOrFail($id);
        $assets = $lease->assets()
            ->with(['category', 'brand'])
            ->paginate(10);
            
        return view('fcu-ams.lease.view-lease', compact('lease', 'assets'));
    }

    // public function endLease(Request $request, Lease $lease)
    // {
    //     foreach ($lease->assets as $asset) {
    //         $asset->status_id = Status::where('status', 'Available')->first()->id;
    //         $asset->save();
    //     }

    //     return redirect()->route('lease.index')->with('success', 'Lease ended successfully.');
    // }

}
