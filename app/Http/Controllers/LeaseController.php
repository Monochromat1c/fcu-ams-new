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

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $leases = Lease::with('assets');

        if ($search) {
            $leases = $leases->where(function ($q) use ($search) {
                $q->where('leases.id', 'like', '%' . $search . '%')
                    ->orWhere('leases.lease_date', 'like', '%' . $search . '%')
                    ->orWhere('leases.lease_expiration', 'like', '%' . $search . '%')
                    ->orWhere('leases.customer', 'like', '%' . $search . '%')
                    ->orWhereHas('assets', function ($q) use ($search) {
                        $q->where('assets.asset_tag_id', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->input('clear') == 'true') {
            return redirect()->route('lease.index');
        }

        if ($sort && $direction) {
            if ($sort == 'lease_date') {
                $leases = $leases->orderBy('leases.lease_date', $direction);
            } elseif ($sort == 'lease_expiration') {
                $leases = $leases->orderBy('leases.lease_expiration', $direction);
            } elseif ($sort == 'customer') {
                $leases = $leases->orderBy('leases.customer', $direction);
            } elseif ($sort == 'asset_tag_id') {
                $leases = $leases->orderBy('assets.asset_tag_id', $direction);
            } else {
                $leases = $leases->orderBy($sort, $direction);
            }
        } else {
            $leases = $leases->orderBy('id', 'asc');
        }

        $leases = $leases->paginate(5);

        return view('fcu-ams/lease/lease', compact('leases', 'sort', 'direction', 'search'));
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
        $lease = new Lease();
        $lease->lease_date = $request->input('lease_date');
        $lease->lease_expiration = $request->input('lease_expiration');
        $lease->customer = $request->input('customer');
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

    // public function endLease(Request $request, Lease $lease)
    // {
    //     foreach ($lease->assets as $asset) {
    //         $asset->status_id = Status::where('status', 'Available')->first()->id;
    //         $asset->save();
    //     }

    //     return redirect()->route('lease.index')->with('success', 'Lease ended successfully.');
    // }

}
