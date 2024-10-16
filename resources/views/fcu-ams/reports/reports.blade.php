@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/asset.css') }}">
<style>
    @media print {
        body {
            background-color: white;
        }

        .fcu-icon {
            filter: grayscale(100%);
        }

        .no-print {
            display: none;
        }

        @page {
            size: auto;
            margin: 0mm;
        }

        .shadow-lg {
            box-shadow: none;
        }
    }
</style>
<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="bg-white flex justify-between py-3 px-4 m-3 shadow-md rounded-md">
            <div></div>
            <h1 class="my-auto text-3xl">Reports</h1>
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
        <div class="content-area mx-3">
            @if($purchaseOrders->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-6 mb-3">
                    <div class="flex align-items-center flex-col">
                        <h2 class="text-2xl mb-2">Purchase Order Record</h2>
                        <p class="text-center text-xl text-gray-500">No purchase order records as of the moment.</p>
                    </div>
                </div>
            @else
            <div class="bg-white rounded-lg shadow-md p-6 lowStock mb-3">
                <div class="flex justify-between align-items-center">
                    <h2 class="text-2xl mb-2">Purchase Order Record</h2>
                    <div class="pagination-here flex justify-between align-items-center">
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link my-auto" href="{{ $purchaseOrders->url(1) }}">
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
                                    <a class="page-link my-auto" href="{{ $purchaseOrders->previousPageUrl() }}">
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
                            Showing {{ $purchaseOrders->firstItem() }} to {{ $purchaseOrders->lastItem() }} of
                            {{ $purchaseOrders->total() }} items
                        </div>
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1">
                                    <a class="page-link" href="{{ $purchaseOrders->nextPageUrl() }}">
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
                                        href="{{ $purchaseOrders->url($purchaseOrders->lastPage()) }}">
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
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Requesting Department</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">PO Date</th>
                            <th class="px-4 py-2 text-center bg-slate-200 border border-slate-400">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrders as $record)
                            <tr class="hover:bg-slate-100">
                                <td class="border border-slate-300 px-4 py-2">{{ $record->department->department }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $record->po_date }}</td>
                                <td class="border border-slate-300 text-center px-4 py-2">
                                    <a href="{{ route('purchase-order-details', $record->id) }}"
                                        class="text-green-600 mx-auto">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            @if($stockOutRecords->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-6 mb-3">
                    <div class="flex align-items-center flex-col">
                        <h2 class="text-2xl mb-2">Stock Out Record</h2>
                        <p class="text-center text-xl text-gray-500">No stock out records as of the moment.</p>
                    </div>
                </div>
            @else
            <div class="bg-white rounded-lg shadow-md p-6 lowStock mb-3">
                <div class="flex justify-between align-items-center">
                    <h2 class="text-2xl mb-2">Stock Out Record</h2>
                    <div class="pagination-here flex justify-between align-items-center">
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1 my-auto">
                                    <a class="page-link my-auto" href="{{ $stockOutRecords->url(1) }}">
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
                                    <a class="page-link my-auto" href="{{ $stockOutRecords->previousPageUrl() }}">
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
                            Showing {{ $stockOutRecords->firstItem() }} to {{ $stockOutRecords->lastItem() }} of
                            {{ $stockOutRecords->total() }} items
                        </div>
                        <div class="flex align-items-center">
                            <ul class="pagination my-auto flex">
                                <li class="page-item p-1">
                                    <a class="page-link" href="{{ $stockOutRecords->nextPageUrl() }}">
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
                                        href="{{ $stockOutRecords->url($stockOutRecords->lastPage()) }}">
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
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Receiver</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Stock Out Date</th>
                            <th class="px-4 py-2 text-center bg-slate-200 border border-slate-400">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockOutRecords as $record)
                            <tr class="hover:bg-slate-100">
                                <td class="border border-slate-300 px-4 py-2">{{ $record->receiver }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $record->stock_out_date }}</td>
                                <td class="border border-slate-300 text-center px-4 py-2">
                                    <a href="{{ route('stock.out.details', $record->id) }}"
                                        class="text-green-600 mx-auto">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            @if($inventories->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-6 mb-3">
                    <div class="flex align-items-center flex-col">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl mb-2">Supplies Purchased Within This Month</h2>
                        </div>
                        <p class="text-center text-xl text-gray-500">No supplies purchased within this month.</p>
                    </div>
                </div>
            @else
            <div class="bg-white rounded-lg shadow-md p-6 purchasedThisWeek mb-3">
                <div class="flex flex-col justify-between align-items-center mb-2">
                    <h2 class="text-2xl mb-2">Supplies Purchased Within This Month</h2>
                    <div class="flex justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 hover:scale-105 hover:shadow-md transition-all ease-in text-white font-bold py-2 px-6 rounded"
                            onclick="printSuppliesTable()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                            </svg>
                        </button>
                        <div class="pagination-here flex my-auto justify-between align-items-center">
                            <div class="flex align-items-center">
                                <ul class="pagination my-auto flex">
                                    <li class="page-item p-1 my-auto">
                                        <a class="page-link my-auto" href="{{ $inventories->url(1) }}">
                                            <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="previous">
                                                    <g id="previous_2">
                                                        <path id="Combined Shape" fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M28.9682 15.5438L39.257 8.52571C41.2485 7.16707 43.9486 8.59383 43.9486 11.0038V36.9158C43.9486 39.3272 41.249 40.7548 39.257 39.3958L20.2635 26.4382C18.5169 25.2492 18.5171 22.6726 20.2631 21.4817L26.9682 16.908V11.0064C26.9682 10.2023 26.0683 9.7271 25.4042 10.1802L6.43638 23.134C5.85532 23.5311 5.85532 24.3887 6.43618 24.7866L25.4038 37.7403C26.0683 38.1936 26.9682 37.7185 26.9682 36.9144V35.9744C26.9682 35.4221 27.4159 34.9744 27.9682 34.9744C28.5205 34.9744 28.9682 35.4221 28.9682 35.9744V36.9144C28.9682 39.3259 26.2685 40.7513 24.2762 39.3922L5.30706 26.4374C3.56509 25.2441 3.56509 22.6737 5.30824 21.4826L24.2766 8.52831C26.2685 7.16942 28.9682 8.59489 28.9682 11.0064V15.5438ZM26.9682 19.329V23.0024C26.9682 23.5547 27.4159 24.0024 27.9682 24.0024C28.5205 24.0024 28.9682 23.5547 28.9682 23.0024V17.9648L40.3841 10.1779C41.048 9.72496 41.9486 10.2009 41.9486 11.0038V36.9158C41.9486 37.7205 41.0482 38.1967 40.3842 37.7437L21.3892 24.785C20.8083 24.3898 20.8083 23.5308 21.3901 23.1339L26.9682 19.329Z"
                                                            fill="#000000" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="page-item p-1 my-auto">
                                        <a class="page-link my-auto" href="{{ $inventories->previousPageUrl() }}">
                                            <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24"
                                                id="previous" data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
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
                                        <a class="page-link"
                                            href="{{ $inventories->url($inventories->lastPage()) }}">
                                            <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="next">
                                                    <g id="next_2">
                                                        <path id="Combined Shape" fill-rule="evenodd"
                                                            clip-rule="evenodd"
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
                </div>
                <!-- FOR PRINTING SUPPLIES PURCHASED EVERY MONTH -->
                <div id="printableSuppliesTable" class="hidden my-5">
                    <div class="text-center mb-5">
                        <!-- <img class="fcu-icon mb-3 w-28 mx-auto" src="/img/login/fcu-icon.png" alt="" srcset=""> -->
                        <h2 class="text-2xl font-bold">FILAMER CHRISTIAN UNIVERSITY, INC</h2>
                        <h2 class="text-xl font-bold mb-3">Roxas Avenue, Roxas City</h2>
                        <h2 class="text-xl font-bold">OFFICE SUPPLIES INVENTORY (Per Month)</h2>
                        <h2 class="text-xl font-bold">on {{ now()->format('M j, Y') }}</h2>
                    </div>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400  whitespace-nowrap">Unique Tag</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400  whitespace-nowrap">Items & Specs</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400  whitespace-nowrap">Brand</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400  whitespace-nowrap">Quantity</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400  whitespace-nowrap">Unit Price</th>
                                <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400  whitespace-nowrap">Total Item Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventoriesForPrint as $inventory)
                                <tr class="hover:bg-slate-100">
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->unique_tag }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->items_specs }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->brand->brand }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->quantity }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">{{ $inventory->unit_price }}</td>
                                    <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">
                                        {{ number_format($inventory->quantity * $inventory->unit_price, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <td colspan="" class=" border-slate-300 px-4 py-2 invisible">Total:</td>
                                <td colspan="" class=" border-slate-300 px-4 py-2 invisible">Total:</td>
                                <td colspan="" class=" border-slate-300 px-4 py-2 invisible">Total:</td>
                                <td colspan="" class=" border-slate-300 px-4 py-2 text-right">Overall Price:</td>
                                <td class="border-slate-300 px-4 py-2">
                                    {{ number_format($inventoriesForPrint->sum('quantity') * $inventoriesForPrint->avg('unit_price'), 2) }}
                                </td>
                            </tr>
                        </tfoot> -->
                    </table>
                    <div class="flex w-full flex-col">
                        <div class="m ml-auto my-2">
                            <div class="flex gap-2">
                                <span class="text-lg">Overall Price: </span>
                                <span class="text-lg">{{ number_format($inventoriesForPrint->sum('quantity') * $inventoriesForPrint->avg('unit_price'), 2) }}</span>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">SHERALYN A. DE LEON</h2>
                            <h2 class="text-lg italic font-bold">Acting - Property Custodian</h2>
                        </div>
                    </div>
                </div>
                <!-- END -->
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <!-- <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400  whitespace-nowrap">ID</th> -->
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Unique Tag</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Items & Specs</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Quantity</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Unit</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Unit Price</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
                            <tr class="hover:bg-slate-100">
                                <!-- <td class="border border-slate-300 px-4 py-2">{{ $inventory->id }}</td> -->
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unique_tag }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->items_specs }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->quantity }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit->unit }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $inventory->unit_price }}</td>
                                <td class="border border-slate-300 px-4 py-2">
                                    {{ $inventory->supplier->supplier }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            @if($assets->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-6 mb-3">
                    <div class="flex align-items-center flex-col">
                        <h2 class="text-2xl mb-2">Assets Purchased Within This Month</h2>
                        <p class="text-center text-xl text-gray-500">No assets purchased within this month.</p>
                    </div>
                </div>
            @else
            <div class="bg-white rounded-lg shadow-md p-6 assets mb-3">
                <div class="flex flex-col my-auto">
                    <h2 class="text-2xl mb-2">Assets Purchased Within This Month</h2>
                    <div class="flex justify-between mb-2">
                        <button class="bg-blue-500 hover:bg-blue-700 hover:scale-105 hover:shadow-md transition-all ease-in text-white font-bold py-2 px-6 rounded"
                            onclick="printAssetsTable()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                            </svg>
                        </button>
                        <div class="pagination-here flex justify-between align-items-center">
                            <div class="flex align-items-center">
                                <ul class="pagination my-auto flex">
                                    <li class="page-item p-1 my-auto">
                                        <a class="page-link my-auto" href="{{ $assets->url(1) }}">
                                            <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="previous">
                                                    <g id="previous_2">
                                                        <path id="Combined Shape" fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M28.9682 15.5438L39.257 8.52571C41.2485 7.16707 43.9486 8.59383 43.9486 11.0038V36.9158C43.9486 39.3272 41.249 40.7548 39.257 39.3958L20.2635 26.4382C18.5169 25.2492 18.5171 22.6726 20.2631 21.4817L26.9682 16.908V11.0064C26.9682 10.2023 26.0683 9.7271 25.4042 10.1802L6.43638 23.134C5.85532 23.5311 5.85532 24.3887 6.43618 24.7866L25.4038 37.7403C26.0683 38.1936 26.9682 37.7185 26.9682 36.9144V35.9744C26.9682 35.4221 27.4159 34.9744 27.9682 34.9744C28.5205 34.9744 28.9682 35.4221 28.9682 35.9744V36.9144C28.9682 39.3259 26.2685 40.7513 24.2762 39.3922L5.30706 26.4374C3.56509 25.2441 3.56509 22.6737 5.30824 21.4826L24.2766 8.52831C26.2685 7.16942 28.9682 8.59489 28.9682 11.0064V15.5438ZM26.9682 19.329V23.0024C26.9682 23.5547 27.4159 24.0024 27.9682 24.0024C28.5205 24.0024 28.9682 23.5547 28.9682 23.0024V17.9648L40.3841 10.1779C41.048 9.72496 41.9486 10.2009 41.9486 11.0038V36.9158C41.9486 37.7205 41.0482 38.1967 40.3842 37.7437L21.3892 24.785C20.8083 24.3898 20.8083 23.5308 21.3901 23.1339L26.9682 19.329Z"
                                                            fill="#000000" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="page-item p-1 my-auto">
                                        <a class="page-link my-auto" href="{{ $assets->previousPageUrl() }}">
                                            <svg fill="#000000" class="w-5 h-5 my-auto" viewBox="0 0 24 24"
                                                id="previous" data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
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
                                Showing {{ $assets->firstItem() }} to {{ $assets->lastItem() }} of
                                {{ $assets->total() }} items
                            </div>
                            <div class="flex align-items-center">
                                <ul class="pagination my-auto flex">
                                    <li class="page-item p-1">
                                        <a class="page-link" href="{{ $assets->nextPageUrl() }}">
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
                                        <a class="page-link" href="{{ $assets->url($assets->lastPage()) }}">
                                            <svg class="w-5 h-5 my-auto" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="next">
                                                    <g id="next_2">
                                                        <path id="Combined Shape" fill-rule="evenodd"
                                                            clip-rule="evenodd"
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
                        <!-- FOR PRINTING ASSETS PURCHASED EVERY MONTH -->
                        <div id="printableAssetsTable" class="hidden my-5">
                            <div class="text-center mb-5">
                                <!-- <img class="fcu-icon mb-3 w-28 mx-auto" src="/img/login/fcu-icon.png" alt="" srcset=""> -->
                                <h2 class="text-2xl font-bold">FILAMER CHRISTIAN UNIVERSITY, INC</h2>
                                <h2 class="text-xl font-bold mb-3">Roxas Avenue, Roxas City</h2>
                                <h2 class="text-xl font-bold">ASSETS (Per Month)</h2>
                                <h2 class="text-xl font-bold">on {{ now()->format('M j, Y') }}
                                </h2>
                            </div>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Asset Tag ID</th>
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Specification</th>
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Brand</th>
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Model</th>
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Serial Number</th>
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Category</th>
                                        <!-- <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Site</th> -->
                                        <!-- <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Location</th> -->
                                        <!-- <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Department</th> -->
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Cost</th>
                                        <!-- <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Supplier</th> -->
                                        <!-- <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Purchase Date</th> -->
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Status</th>
                                        <th
                                            class="px-4 py-2 text-left bg-slate-200 border border-slate-400 whitespace-nowrap">
                                            Condition</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assets as $asset)
                                        <tr class="hover:bg-slate-100">
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->asset_tag_id }}</td>
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->specs }}</td>
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->brand->brand }}</td>
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->model }}</td>
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->serial_number }}</td>
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->category->category }}</td>
                                            <!-- <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->site->site }}</td> -->
                                            <!-- <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->location->location }}</td> -->
                                            <!-- <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->department->department }}</td> -->
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->cost }}</td>
                                            <!-- <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->supplier->supplier }}</td> -->
                                            <!-- <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->purchase_date }}</td> -->
                                            <td class="border border-slate-300 px-4 py-2 whitespace-nowrap">
                                                {{ $asset->status->status }}</td>
                                            <td class="border border-slate-300 px-4 py-2  whitespace-nowrap">{{ $asset->condition->condition }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="flex w-full flex-col">
                                <div class="m ml-auto my-2">
                                    <div class="flex gap-2">
                                        <span class="text-lg">Total Asset Value: </span>
                                        <span
                                            class="text-lg">{{ number_format($assets->sum('cost'), 2) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold">SHERALYN A. DE LEON</h2>
                                    <h2 class="text-lg italic font-bold">Acting - Property Custodian</h2>
                                </div>
                            </div>
                        </div>
                        <!-- END -->
                    </div>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Asset Tag ID</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Specification</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Brand</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Model</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Serial Number</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Cost</th>
                            <th class="px-4 py-2 text-left bg-slate-200 border border-slate-400">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                            <tr class="hover:bg-slate-100">
                                <td class="border border-slate-300 px-4 py-2">{{ $asset->asset_tag_id }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $asset->specs }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $asset->brand->brand }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $asset->model }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $asset->serial_number }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $asset->cost }}</td>
                                <td class="border border-slate-300 px-4 py-2">{{ $asset->supplier->supplier }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    function printSuppliesTable() {
        var printContents = document.getElementById("printableSuppliesTable").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
<script>
    function printAssetsTable() {
        var printContents = document.getElementById("printableAssetsTable").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
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
