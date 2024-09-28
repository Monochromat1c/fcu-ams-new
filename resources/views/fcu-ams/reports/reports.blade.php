@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">

<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Reports</h1>
            <a href="" class="flex space-x-1" style="min-width:100px;">
                <svg class="h-10 w-10 my-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <p class="my-auto">Lighttt</p>
            </a>
        </nav>
        <div class="content-area mx-3">
            <div class="bg-white rounded-lg shadow-md p-6 lowStock mb-3">
                <h2 class="text-2xl mb-2">Stock Out Records</h2>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">ID</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Receiver</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Stock Out Date</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockOutRecords as $record)
                            <tr>
                                <td class="border border-slate-300 px-4 py-2">{{ $record->id }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $record->receiver }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $record->stock_out_date }}</td>
                                <td class="border border-slate-300 px-4 py-2">
                                    <a href="{{ route('stock.out.details', $record->id) }}" class="text-green-600">View
                                        Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 purchasedThisWeek mb-3">
                <div class="flex justify-between align-items-center">
                    <h2 class="text-2xl mb-2">Supplies purchased this week</h2>
                    <div class="pagination-here flex justify-between align-items-center">
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link my-auto" href="{{ $inventories->url(1) }}">
                                        <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="previous">
                                                <g id="previous_2">
                                                    <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M28.9682 15.5438L39.257 8.52571C41.2485 7.16707 43.9486 8.59383 43.9486 11.0038V36.9158C43.9486 39.3272 41.249 40.7548 39.257 39.3958L20.2635 26.4382C18.5169 25.2492 18.5171 22.6726 20.2631 21.4817L26.9682 16.908V11.0064C26.9682 10.2023 26.0683 9.7271 25.4042 10.1802L6.43638 23.134C5.85532 23.5311 5.85532 24.3887 6.43618 24.7866L25.4038 37.7403C26.0683 38.1936 26.9682 37.7185 26.9682 36.9144V35.9744C26.9682 35.4221 27.4159 34.9744 27.9682 34.9744C28.5205 34.9744 28.9682 35.4221 28.9682 35.9744V36.9144C28.9682 39.3259 26.2685 40.7513 24.2762 39.3922L5.30706 26.4374C3.56509 25.2441 3.56509 22.6737 5.30824 21.4826L24.2766 8.52831C26.2685 7.16942 28.9682 8.59489 28.9682 11.0064V15.5438ZM26.9682 19.329V23.0024C26.9682 23.5547 27.4159 24.0024 27.9682 24.0024C28.5205 24.0024 28.9682 23.5547 28.9682 23.0024V17.9648L40.3841 10.1779C41.048 9.72496 41.9486 10.2009 41.9486 11.0038V36.9158C41.9486 37.7205 41.0482 38.1967 40.3842 37.7437L21.3892 24.785C20.8083 24.3898 20.8083 23.5308 21.3901 23.1339L26.9682 19.329Z"
                                                        fill="#000000" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link my-auto" href="{{ $inventories->previousPageUrl() }}">
                                        <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="previous"
                                            data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
                                            class="icon line-color">
                                            <path id="primary" d="M17,3V21L5,12Z"
                                                style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                            </path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="text-center my-auto pr-4 pl-4 font_bold">
                            Showing {{ $inventories->firstItem() }} to {{ $inventories->lastItem() }} of
                            {{ $inventories->total() }} items
                        </div>
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1">
                                    <a class="page-link" href="{{ $inventories->nextPageUrl() }}">
                                        <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="next"
                                            data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
                                            class="icon line-color">
                                            <path id="primary" d="M17,12,5,21V3Z"
                                                style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                            </path>
                                        </svg>
                                    </a>
                                </li>
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link" href="{{ $inventories->url($inventories->lastPage()) }}">
                                        <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="next">
                                                <g id="next_2">
                                                    <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M18.9792 32.3759L8.69035 39.3951C6.69889 40.7537 3.99878 39.3269 3.99878 36.917V11.005C3.99878 8.59361 6.69843 7.166 8.69028 8.52489L27.6843 21.4809C29.4304 22.672 29.4304 25.249 27.6843 26.4371L20.9792 31.0114V36.9144C20.9792 37.7185 21.8791 38.1937 22.5432 37.7406L41.5107 24.787C42.0938 24.3882 42.0938 23.5316 41.5112 23.1342L22.5436 10.1805C21.8791 9.72714 20.9792 10.2023 20.9792 11.0064V11.9464C20.9792 12.4987 20.5315 12.9464 19.9792 12.9464C19.4269 12.9464 18.9792 12.4987 18.9792 11.9464V11.0064C18.9792 8.59492 21.6789 7.16945 23.6711 8.52861L42.6387 21.4823C44.3845 22.6732 44.3845 25.2446 42.6391 26.4382L23.6707 39.3925C21.6789 40.7514 18.9792 39.3259 18.9792 36.9144V32.3759ZM18.9792 29.9548L7.56322 37.7429C6.89939 38.1958 5.99878 37.7199 5.99878 36.917V11.005C5.99878 10.2003 6.89924 9.72409 7.56321 10.1771L26.5573 23.1331C27.1391 23.53 27.1391 24.389 26.5582 24.7842L20.9792 28.5904V24.9184C20.9792 24.3661 20.5315 23.9184 19.9792 23.9184C19.4269 23.9184 18.9792 24.3661 18.9792 24.9184V29.9548Z"
                                                        fill="#000000" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <!-- <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">ID</th> -->
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unique Tag</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Items & Specs</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Quantity</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unit</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unit Price</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
                            <tr>
                                <!-- <td class="border border-slate-300 px-4 py-2">{{ $inventory->id }}</td> -->
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unique_tag }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->items_specs }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->quantity }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit_price }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->supplier->supplier }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 lowStock mb-3">
                <div class="flex justify-between align-items-center">
                    <h2 class="text-2xl mb-2">Low Stock Supplies</h2>
                    <div class="pagination-here flex justify-between align-items-center">
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link my-auto" href="{{ $lowStockInventories->url(1) }}">
                                        <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="previous">
                                                <g id="previous_2">
                                                    <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M28.9682 15.5438L39.257 8.52571C41.2485 7.16707 43.9486 8.59383 43.9486 11.0038V36.9158C43.9486 39.3272 41.249 40.7548 39.257 39.3958L20.2635 26.4382C18.5169 25.2492 18.5171 22.6726 20.2631 21.4817L26.9682 16.908V11.0064C26.9682 10.2023 26.0683 9.7271 25.4042 10.1802L6.43638 23.134C5.85532 23.5311 5.85532 24.3887 6.43618 24.7866L25.4038 37.7403C26.0683 38.1936 26.9682 37.7185 26.9682 36.9144V35.9744C26.9682 35.4221 27.4159 34.9744 27.9682 34.9744C28.5205 34.9744 28.9682 35.4221 28.9682 35.9744V36.9144C28.9682 39.3259 26.2685 40.7513 24.2762 39.3922L5.30706 26.4374C3.56509 25.2441 3.56509 22.6737 5.30824 21.4826L24.2766 8.52831C26.2685 7.16942 28.9682 8.59489 28.9682 11.0064V15.5438ZM26.9682 19.329V23.0024C26.9682 23.5547 27.4159 24.0024 27.9682 24.0024C28.5205 24.0024 28.9682 23.5547 28.9682 23.0024V17.9648L40.3841 10.1779C41.048 9.72496 41.9486 10.2009 41.9486 11.0038V36.9158C41.9486 37.7205 41.0482 38.1967 40.3842 37.7437L21.3892 24.785C20.8083 24.3898 20.8083 23.5308 21.3901 23.1339L26.9682 19.329Z"
                                                        fill="#000000" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link my-auto" href="{{ $lowStockInventories->previousPageUrl() }}">
                                        <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="previous"
                                            data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
                                            class="icon line-color">
                                            <path id="primary" d="M17,3V21L5,12Z"
                                                style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                            </path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="text-center my-auto pr-4 pl-4 font_bold">
                            Showing {{ $lowStockInventories->firstItem() }} to
                            {{ $lowStockInventories->lastItem() }} of
                            {{ $lowStockInventories->total() }} items
                        </div>
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1">
                                    <a class="page-link" href="{{ $lowStockInventories->nextPageUrl() }}">
                                        <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24" id="next"
                                            data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
                                            class="icon line-color">
                                            <path id="primary" d="M17,12,5,21V3Z"
                                                style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                            </path>
                                        </svg>
                                    </a>
                                </li>
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link"
                                        href="{{ $lowStockInventories->url($lowStockInventories->lastPage()) }}">
                                        <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="next">
                                                <g id="next_2">
                                                    <path id="Combined Shape" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M18.9792 32.3759L8.69035 39.3951C6.69889 40.7537 3.99878 39.3269 3.99878 36.917V11.005C3.99878 8.59361 6.69843 7.166 8.69028 8.52489L27.6843 21.4809C29.4304 22.672 29.4304 25.249 27.6843 26.4371L20.9792 31.0114V36.9144C20.9792 37.7185 21.8791 38.1937 22.5432 37.7406L41.5107 24.787C42.0938 24.3882 42.0938 23.5316 41.5112 23.1342L22.5436 10.1805C21.8791 9.72714 20.9792 10.2023 20.9792 11.0064V11.9464C20.9792 12.4987 20.5315 12.9464 19.9792 12.9464C19.4269 12.9464 18.9792 12.4987 18.9792 11.9464V11.0064C18.9792 8.59492 21.6789 7.16945 23.6711 8.52861L42.6387 21.4823C44.3845 22.6732 44.3845 25.2446 42.6391 26.4382L23.6707 39.3925C21.6789 40.7514 18.9792 39.3259 18.9792 36.9144V32.3759ZM18.9792 29.9548L7.56322 37.7429C6.89939 38.1958 5.99878 37.7199 5.99878 36.917V11.005C5.99878 10.2003 6.89924 9.72409 7.56321 10.1771L26.5573 23.1331C27.1391 23.53 27.1391 24.389 26.5582 24.7842L20.9792 28.5904V24.9184C20.9792 24.3661 20.5315 23.9184 19.9792 23.9184C19.4269 23.9184 18.9792 24.3661 18.9792 24.9184V29.9548Z"
                                                        fill="#000000" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unique Tag</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Items & Specs</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Quantity</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unit</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Unit Price</th>
                            <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockInventories as $inventory)
                            <tr>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unique_tag }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->items_specs }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->quantity }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit_price }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->supplier->supplier }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 lowStock mb-3">
                <h2 class="text-2xl">Work in progress...</h2>
            </div>
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
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this asset?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

</script>
<script>
    function clearSearch() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('form').submit();
    }

</script>
<script>
    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (window.performance.navigation.type === 1 && urlParams.has('search')) {
            window.location.href = "{{ route('asset.list') }}";
        }
    };

</script>

@endsection
