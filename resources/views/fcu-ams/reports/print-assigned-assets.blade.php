@extends('layouts.layout')
@section('content')
<style>
    body {
        --tw-bg-opacity: 1;
        background-color: rgb(241 245 249 / var(--tw-bg-opacity));
    }
    .fcu-icon {
        filter: grayscale(100%);
        position: absolute;
        top: 40px;
        left: 70px;
        width: 100px;
        height: auto;
    }
    .print-card {
        background: #fff;
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 2.25rem;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
    }
    .print-wrapper {
        /* For screen, no extra margin */
    }
    @media print {
        body {
            background-color: white !important;
            margin: 0;
            padding: 15px;
            font-size: 14px !important;
        }
        .no-print {
            display: none !important;
        }
        .print-wrapper {
            margin: 24px !important; /* 24px = ~0.33in, adjust as needed */
        }
        .print-card {
            background: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
        }
        .fcu-icon {
            position: absolute;
            top: 40px;
            left: 70px;
            width: 100px;
            height: auto;
        }
        @page {
            size: auto;
            margin: 24px; /* 24px all around, or use 0.5in for more space */
        }
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2rem;
    }
    th, td {
        border-bottom: 1px solid #e5e7eb;
        padding: 0.75rem 0.5rem;
        text-align: left;
        font-size: 0.95rem;
        vertical-align: top;
    }
    th {
        background-color: #f3f4f6;
        font-weight: 600;
    }
    tr:last-child td {
        border-bottom: none;
    }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .font-bold { font-weight: bold; }
    .mb-3 { margin-bottom: 0.75rem; }
    .mb-5 { margin-bottom: 1.25rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mt-8 { margin-top: 2rem; }
    .text-sm { font-size: 0.95rem; }
    .text-xl { font-size: 1.25rem; }
    .text-lg { font-size: 1.1rem; }
    .text-gray-600 { color: #4b5563; }
    .bg-gray-100 { background-color: #f3f4f6; }
    .rounded { border-radius: 0.5rem; }
    .p-2 { padding: 0.5rem; }
    .p-4 { padding: 1rem; }
    .p-8 { padding: 2rem; }
    .mx-auto { margin-left: auto; margin-right: auto; }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1); }
    .bg-white { background: #fff; }
</style>
<div class="print-wrapper">
    <div class="print-card">
        <div class="text-center mb-5 relative">
            <img class="fcu-icon" src="{{ asset('img/login/fcu-icon.png') }}" alt="FCU Icon">
            <h2 class="text-xl font-bold">FILAMER CHRISTIAN UNIVERSITY, INC.</h2>
            <h2 class="text-lg font-bold mb-3">Roxas Avenue, Roxas City</h2>
            <h2 class="text-lg font-bold">Assigned Assets Report</h2>
            <p class="text-gray-600 mb-3 text-sm">Report Generated: {{ $currentDate }}</p>
            <h2 class="text-lg font-bold">Assignee: {{ $assignee }}</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Asset Tag ID</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Serial Number</th>
                    <th>Department</th>
                    <th>Site</th>
                    <th>Status</th>
                    <th>Condition</th>
                    <th class="text-left">Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                    <tr>
                        <td>{{ $asset->asset_tag_id }}</td>
                        <td>{{ $asset->brand->brand }}</td>
                        <td>{{ $asset->model }}</td>
                        <td>{{ $asset->serial_number }}</td>
                        <td>{{ $asset->department->department }}</td>
                        <td>{{ $asset->site->site }}</td>
                        <td>{{ $asset->status->status }}</td>
                        <td>{{ $asset->condition->condition }}</td>
                        <td class="text-left">{{ number_format($asset->cost, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>

        <div class="text-sm mb-4 flex flex-col">
            <div class="flex flex-row">
                <p class="font-bold segoe mr-3">Total Number of Assets: </p>
                <p class="">{{ $assets->count() }}</p>
            </div>
            <div class="flex flex-row">
                <p class="font-bold segoe mr-3">Total Value: </p>
                <p class="">PHP {{ number_format($totalValue, 2) }}</p>
            </div>
        </div>

        <div class="flex justify-between mt-8 no-print">
            <button onclick="window.location.href='/reports'"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </button>
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection 