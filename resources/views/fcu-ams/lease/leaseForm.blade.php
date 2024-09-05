@extends('layouts.layout')

@section('content')
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Lease Form</h1>
            <div></div>
        </nav>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <form action="{{ route('lease.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="lease_date" class="form-label">Lease Date</label>
                    <input type="date" id="lease_date" name="lease_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lease_expiration" class="form-label">Lease Expiration</label>
                    <input type="date" id="lease_expiration" name="lease_expiration" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="customer" class="form-label">Customer</label>
                    <input type="text" id="customer" name="customer" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea id="note" name="note" class="form-control"></textarea>
                </div>
                @foreach($assets as $asset)
                    <input type="hidden" name="selected_assets[]" value="{{ $asset->id }}">
                @endforeach
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Asset Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                    <tr>
                        <td>{{ $asset->asset_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection