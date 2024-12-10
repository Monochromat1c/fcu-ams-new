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
                    class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white flex gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                    </svg>
                    Submit
                </button>
            </form>
        </div>
        <div class="bg-white p-5 shadow-md m-3 rounded-md max-h-96 overflow-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                        <th class="px-4 py-3 text-left font-semibold tracking-wider uppercase text-sm">Asset Tag ID</th>
                        <th class="px-4 py-3 text-left font-semibold tracking-wider uppercase text-sm">Specs</th>
                        <th class="px-4 py-3 text-left font-semibold tracking-wider uppercase text-sm">Model</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($assets as $asset)
                        <tr class="transition-all duration-200 hover:bg-blue-50">
                            <td class="px-4 py-3 text-gray-700">{{ $asset->asset_tag_id }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $asset->specs }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $asset->model }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($assets->isEmpty())
                <div class="text-center py-4 text-gray-500">
                    No assets available
                </div>
            @endif
        </div>
    </div>
</div>
@endsection