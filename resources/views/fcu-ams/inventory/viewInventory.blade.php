@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/viewInventory.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Inventory</h1>
            <a href="{{ route('profile.index') }}" class="flex space-x-1" style="min-width:100px;">
                <img src="{{ asset('profile/profile.png') }}" class="w-10 h-10 rounded-full" alt="" srcset="">
                <p class="my-auto">Lighttt</p>
            </a>
        </nav>
        <div class="bg-white p-5 shadow-md m-3 rounded-md">
            <div class="flex justify-between mb-3">
                <h2 class="text-2xl font-bold my-auto">View Inventory</h2>
                <div class="flex align-items-center gap-1">
                    <a href="{{ route('inventory.list') }}"
                        class="rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500 transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Back
                        to Inventory List</a>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">ID</th>
                            <th class="px-4 py-2 text-center bg-slate-100 border border-slate-400">Supply Image</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Brand</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Items & Specs</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Quantity</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unit</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unit Price</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Supplier</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Total Item Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-slate-300 px-4 py-2">{{ $inventory->id }}</td>
                            <td class="border border-slate-300 px-4 py-2">
                                @if($inventory->stock_image)
                                    <img src="{{ asset($inventory->stock_image) }}" alt="Inventory Image"
                                        class="mx-auto rounded-full" style="width:2.7rem;height:2.7rem;">
                                @else
                                    <img src="{{ asset('profile/default.png') }}"
                                        alt="Default Image" class="w-14 h-14 rounded-full mx-auto">
                                @endif
                            </td>
                            <td class="border border-slate-300 px-4 py-2">{{ $inventory->brand }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $inventory->items_specs }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $inventory->quantity }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit->unit }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit_price }}</td>
                            <td class="border border-slate-300 px-4 py-2">{{ $inventory->supplier->supplier }}</td>
                            <td class="border border-slate-300 px-4 py-2">
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
    function confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
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