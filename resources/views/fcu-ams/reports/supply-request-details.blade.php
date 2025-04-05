@extends('layouts.layout')
@section('content')
<style>
    body {
        background-color: #f1f5f9;
    }

    .fcu-icon {
        filter: grayscale(100%);
        position: absolute;
        top: 40px;
        left: 70px;
        width: 100px;
        height: auto;
    }

    @media print {
        body {
            background-color: white;
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

<div class="bg-white rounded-lg p-8 mb-8 max-w-2xl my-9 mx-auto shadow-lg">
    <div class="text-center mb-5 relative">
        <img class="fcu-icon" src="/img/login/fcu-icon.png" alt="FCU Logo">
        <h2 class="text-xl font-bold">FILAMER CHRISTIAN UNIVERSITY, INC</h2>
        <h2 class="text-lg font-bold mb-3">Roxas Avenue, Roxas City</h2>
        <h2 class="text-lg font-bold">Supply Request Details</h2>
        <p class="text-gray-600 mb-3 text-sm">Request Date: {{ \Carbon\Carbon::parse($requestGroup->first()->request_date)->format('M d, Y') }}</p>
        <h2 class="text-lg font-bold">{{ $requestGroup->first()->department->department }}</h2>
    </div>

    <table class="w-full mb-8 text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left font-semibold">Item Name</th>
                <th class="px-4 py-2 text-center font-semibold">Quantity</th>
                <th class="px-4 py-2 text-right font-semibold">Unit Price</th>
                <th class="px-4 py-2 text-right font-semibold">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requestGroup as $request)
                <tr>
                    <td class="border-b px-4 py-2">{{ $request->item_name }}</td>
                    <td class="border-b px-4 py-2 text-center">{{ $request->quantity }}</td>
                    <td class="border-b px-4 py-2 text-right">
                        ₱{{ number_format($request->estimated_unit_price, 2) }}</td>
                    <td class="border-b px-4 py-2 text-right">
                        ₱{{ number_format($request->quantity * $request->estimated_unit_price, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-bold">
                <td class="px-4 py-2" colspan="3">Total Estimated Cost:</td>
                <td class="px-4 py-2 text-right">₱{{ number_format($totalEstimatedCost, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="flex justify-between mt-12 pt-6 border-t text-sm">
        <div class="text-center">
            <p class="font-bold mb-1">Requester:</p>
            <p>{{ $requestGroup->first()->requester }}</p>
        </div>
        <div class="text-center">
            <p class="font-bold mb-1">Department:</p>
            <p>{{ $requestGroup->first()->department->department }}</p>
        </div>
        <div class="text-center">
            <p class="font-bold mb-1">Request Date:</p>
            <p>{{ \Carbon\Carbon::parse($requestGroup->first()->request_date)->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="flex justify-between mt-8 no-print">
        <button onclick="window.history.back()"
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
            Back
        </button>
        <button onclick="window.print()" 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
            Print
        </button>
    </div>
</div>
@endsection 