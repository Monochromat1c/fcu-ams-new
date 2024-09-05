<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use DB;
use App\Models\Lease;
use App\Models\LeaseItem;

class LeaseController extends Controller
{
    public function index(Request $request)
    {
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
                        $q->where('assets.asset_name', 'like', '%' . $search . '%');
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
            } elseif ($sort == 'asset_name') {
                $leases = $leases->orderBy('assets.asset_name', $direction);
            } else {
                $leases = $leases->orderBy($sort, $direction);
            }
        } else {
            $leases = $leases->orderBy('id', 'asc');
        }

        $leases = $leases->paginate(15);

        return view('fcu-ams/lease/lease', compact('leases', 'sort', 'direction', 'search'));
    }

    public function create()
    {
        $assets = Asset::whereNull('deleted_at')->get();
        return view('fcu-ams/lease/selectAssets', compact('assets'));
    }

    public function store(Request $request)
    {
        $lease = new Lease();
        $lease->lease_date = $request->input('lease_date');
        $lease->lease_expiration = $request->input('lease_expiration');
        $lease->customer = $request->input('customer');
        $lease->note = $request->input('note');
        $lease->save();

        $selectedAssets = $request->input('selected_assets');
        if ($selectedAssets) {
            foreach ($selectedAssets as $assetId) {
                $leaseItem = new LeaseItem();
                $leaseItem->lease_id = $lease->id;
                $leaseItem->asset_id = $assetId;
                $leaseItem->save();
            }
        }

        return redirect()->route('lease.index')->with('success', 'Lease created successfully.');
    }

    public function createForm(Request $request)
    {
        $selectedAssets = $request->input('selected_assets');
        if ($selectedAssets) {
            $assets = Asset::whereIn('id', $selectedAssets)->get();
            return view('fcu-ams/lease/leaseForm', compact('assets', 'selectedAssets'));
        } else {
            return view('fcu-ams/lease/leaseForm');
        }
    }
}
