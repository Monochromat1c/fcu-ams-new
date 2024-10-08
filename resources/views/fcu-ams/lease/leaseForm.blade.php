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
                <div class="mb-4">
                    <label for="lease_date" class="block text-gray-700 font-bold mb-2">Lease Date:</label>
                    <input type="date" id="lease_date" name="lease_date" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="lease_expiration" class="block text-gray-700 font-bold mb-2">Lease Expiration:</label>
                    <input type="date" id="lease_expiration" name="lease_expiration"
                        class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="customer" class="block text-gray-700 font-bold mb-2">Customer:</label>
                    <input type="text" id="customer" name="customer" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="note" class="block text-gray-700 font-bold mb-2">Note:</label>
                    <textarea id="note" name="note" class="w-full p-2 border rounded-md"></textarea>
                </div>
                @foreach($assets as $asset)
                    <input type="hidden" name="selected_assets[]" value="{{ $asset->id }}">
                @endforeach
                <button type="submit"
                    class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Submit</button>
            </form>
        </div>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Asset Tag ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                        <tr>
                            <td class="border border-slate-300 px-4 py-2">{{ $asset->asset_tag_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection