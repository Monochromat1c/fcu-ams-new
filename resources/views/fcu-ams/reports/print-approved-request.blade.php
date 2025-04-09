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

    @media print {
        body {
            background-color: white;
            /* margin: 0;
            padding: 0; */
            font-size: 14px !important; /* Explicitly set font size for print */
        }

        .title {
            font-size: 18px;
        }

        .sub-title {
            font-size: 16px;
        }   

        .no-print {
            display: none;
        }

        @page {
            size: auto;
            margin: -4mm;

        }

        .shadow-lg {
            box-shadow: none;
        }
    }
</style>
<div class="bg-white rounded-lg p-8 mb-8 max-w-3xl my-9 mx-auto shadow-lg">
    <div class="text-center">
        <h2 class="title segoe font-bold">FILAMER CHRISTIAN UNIVERSITY, INC.</h2>
        <h2 class="sub-title segoe font-bold italic">Roxas Avenue, Roxas City</h2>
        <h2 class="sub-title segoe font-bold">PROPERTY CUSTODIAN'S OFFICE</h2>
        
        <table class="w-full">
            <tr>
                <td class="px-2 py-1 segoe font-semibold border border-black text-left">Document Name:</td>
                <td class="px-2 py-1 border border-black text-left">OFFICE SUPPLIES REQUISITION SLIP</td>
                <td class="px-2 py-1 segoe font-semibold border border-black text-left">Effectivity:</td>
                <td class="px-2 py-1 border border-black text-left">August 15, 2022</td>
            </tr>
            <tr>
                <td class="px-2 py-1 segoe font-semibold border border-black text-left">Document No:</td>
                <td class="px-2 py-1 border border-black text-left">PCO-2023-03</td>
                <td class="px-2 py-1 segoe font-semibold border border-black text-left">Issuing Office:</td>
                <td class="px-2 py-1 border border-black text-left" colspan="2">Property Custodian's Office</td>
            </tr>
            <tr>
                <td class="px-2 py-1 segoe font-semibold border border-black text-left">Revision No:</td>
                <td class="px-2 py-1 border border-black text-left">1</td>
                <td class="px-2 py-1 segoe font-semibold border border-black text-left">Page No.</td>
                <td class="px-2 py-1 border border-black text-left" colspan="2">1</td>
            </tr>
        </table>

        <h2 class="segoe font-bold mt-2 mb-2">OFFICE SUPPLIES REQUESITION SLIP</h2>
        <table class="w-full">
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left">Department/Unit:</td>
                <td class="px-2 py-1 text-left">{{ $requests->first()->department->department ?? 'N/A' }}</td>
                <td class="px-2 py-1 segoe font-semibold text-left">Date:</td>
                <td class="px-2 py-1 text-left">{{ \Carbon\Carbon::parse($requests->first()->created_at)->format('M d, Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="w-full border mt-2 mb-4 border-black">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-center segoe font-semibold border border-black">Qty</th>
                <th class="px-4 py-2 text-left segoe font-semibold border border-black">Unit</th>
                <th class="px-4 py-2 text-left segoe font-semibold border border-black">Items</th>
                <th class="px-4 py-2 text-right segoe font-semibold border border-black">Unit Cost</th>
                <th class="px-4 py-2 text-right segoe font-semibold border border-black">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td class="border border-black px-4 py-2 text-center">{{ $request->quantity }}</td>
                    <td class="border border-black px-4 py-2 text-left">
                        @if($request->inventory_id)
                            {{ $request->inventory->unit->unit ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="border border-black px-4 py-2 text-left">{{ $request->item_name }}</td>
                    <td class="border border-black px-4 py-2 text-right">
                        @if($request->inventory_id)
                            ₱{{ number_format($request->inventory->unit_price ?? 0, 2) }}
                        @else
                            ₱{{ number_format($request->estimated_unit_price ?? 0, 2) }}
                        @endif
                    </td>
                    <td class="border border-black px-4 py-2 text-right">
                        @if($request->inventory_id)
                            ₱{{ number_format(($request->inventory->unit_price ?? 0) * $request->quantity, 2) }}
                        @else
                            ₱{{ number_format(($request->estimated_unit_price ?? 0) * $request->quantity, 2) }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="segoe font-bold">
                <td colspan="3"></td>
                <td class="px-4 py-2 text-right border border-black">Grand Total:</td>
                <td class="px-4 py-2 text-right border border-black">₱{{ number_format($totalPrice, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <table class="w-full">
        <div>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left">Requested by:</td>
                <td class="px-2 py-1 segoe font-semibold text-center border-b border-black">
                    {{ $requests->first()->requester }}</td>
                <td class="px-2 py-1 segoe font-semibold text-left pl-10">Stocks Available:</td>
                <td class="px-2 py-1 segoe font-semibold text-left">Budget Available: </td>
            </tr>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left">Dept/Unit: </td>
                <td class="px-2 py-1 segoe font-semibold text-center">
                    {{ $requests->first()->department->department ?? 'N/A' }}</td>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
            </tr>
        </div>
        <div>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left">Noted by:</td>
                <td class="px-2 py-1 segoe font-semibold text-left border-b border-black"></td>
                <td class="px-2 py-1 segoe font-semibold text-left pl-10">SHERALYN A. DE LEON</td>
                <td class="px-2 py-1 segoe font-semibold text-left">MELINOR B. SUMAYGAYSAY</td>
            </tr>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
                <td class="px-2 py-1 segoe font-semibold italic text-center">Head of Office</td>
                <td class="px-2 py-1 segoe font-semibold italic text-left pl-10">Acting Property Custodian</td>
                <td class="px-2 py-1 segoe font-semibold italic text-left">OIC-Accountant</td>
            </tr>
        </div>
        <div>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left">Released by:</td>
                <td class="px-2 py-1 segoe font-semibold text-left border-b border-black"></td>
                <td class="px-2 py-1 segoe font-semibold text-left pl-10"></td>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
            </tr>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
                <td class="px-2 py-1 segoe font-semibold italic text-center">PCO Staff</td>
                <td class="px-2 py-1 segoe font-semibold italic text-left pl-10">Recommending Approval</td>
                <td class="px-2 py-1 segoe font-semibold italic text-left">Approved</td>
            </tr>
        </div>
        <div>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left">Received by:</td>
                <td class="px-2 py-1 segoe font-semibold text-left border-b border-black"></td>
                <td class="px-2 py-1 segoe font-semibold text-left pl-10"></td>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
            </tr>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
                <td class="px-2 py-1 segoe font-semibold italic text-center"></td>
                <td class="px-2 py-1 segoe font-semibold italic text-left pl-10"></td>
                <td class="px-2 py-1 segoe font-semibold italic text-left"></td>
            </tr>
        </div>
        <div>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left">Checker:</td>
                <td class="px-2 py-1 segoe font-semibold text-left border-b border-black"></td>
                <td class="px-2 py-1 segoe font-semibold text-left pl-10">ESTHER S. ARCEÑO,CPA</td>
                <td class="px-2 py-1 segoe font-semibold text-left">DR. GEORGE O. CORTEL</td>
            </tr>
            <tr>
                <td class="px-2 py-1 segoe font-semibold text-left"></td>
                <td class="px-2 py-1 segoe font-semibold italic text-center">PCO Staff</td>
                <td class="px-2 py-1 segoe font-semibold italic text-left pl-10">TIC, VP-Finance</td>
                <td class="px-2 py-1 segoe font-semibold italic text-left">President</td>
            </tr>
        </div>
    </table>

    <!-- <div class="flex justify-between mt-12 pt-6 border-t">
        <div class="text-center">
            <p class="segoe font-bold mb-1">Processed by:</p>
            <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>
        </div>
        <div class="text-center">
            <p class="segoe font-bold mb-1">Requested by:</p>
            <p>{{ $requests->first()->requester }}</p>
        </div>
    </div> -->

    <div class="flex justify-between mt-8 no-print">
        <button onclick="window.history.back()" 
            class="bg-red-500 hover:bg-red-700 text-white segoe font-bold py-2 px-6 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
            </svg>
        </button>
        <button onclick="window.print()" 
            class="bg-blue-500 hover:bg-blue-700 text-white segoe font-bold py-2 px-6 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
        </button>
    </div>
</div>
@endsection