@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/viewInventory.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Inventory</h1>
            <a href="{{ route('profile.index') }}" class="flex gap-3" style="min-width:100px;">
                <!-- <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset=""> -->
                <div>
                     @if(auth()->user()->profile_picture)
                        <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User Profile"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @else
                        <img src="{{ asset('profile/defaultProfile.png') }}" alt="Default Image"
                            class="w-14 h-14  object-cover bg-no-repeat rounded-full mx-auto">
                    @endif
                </div>
                <p class="my-auto">
                    {{ (auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'N/A') }}
                </p>
            </a>
        </nav>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">View Inventory</h2>
                <div class="flex align-items-center gap-1">
                    <a href="{{ route('inventory.list') }}"
                        class="rounded-md shadow-md px-5 py-2 flex gap-2 my-auto bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        Back to Inventory List</a>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center bg-slate-200 border border-slate-400 whitespace-nowrap">Supply Image</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Brand</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Items & Specs</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Quantity</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Unit</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Unit Price</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Supplier</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">Total Item Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-slate-300 px-4 py-2">
                                @if($inventory->stock_image)
                                    <img src="{{ asset($inventory->stock_image) }}" alt="Inventory Image"
                                        class="mx-auto rounded-full" style="width:2.7rem;height:2.7rem;">
                                @else
                                    <img src="{{ asset('profile/defaultIcon.png') }}"
                                        alt="Default Image" class="w-14 h-14 rounded-full mx-auto">
                                @endif
                            </td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->brand->brand }}</td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->items_specs }}</td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->quantity }}</td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->unit->unit }}</td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->unit_price }}</td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->supplier->supplier }}</td>
                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">
                                {{ number_format($inventory->quantity * $inventory->unit_price, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the current URL
        var currentUrl = window.location.href;
        // Get all dropdown buttons
        var dropdownButtons = document.querySelectorAll('.relative button');
        // Loop through each dropdown button
        dropdownButtons.forEach(function (button) {
            // Get the dropdown links
            var dropdownLinks = button.nextElementSibling.querySelectorAll('a');
            // Loop through each dropdown link
            dropdownLinks.forEach(function (link) {
                // Check if the current URL matches the link's href
                if (currentUrl === link.href) {
                    // Open the dropdown
                    button.click();
                }
            });
        });
    });
</script>

@endsection