@extends('layouts.layout')
@section('content')
<style>
    body {
        --tw-bg-opacity: 1;
        background-color: rgb(241 245 249 / var(--tw-bg-opacity));
    }

    .fcu-icon {
        transition: all 0.3s ease;
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

<div class="min-h-screen flex items-center justify-center bg-slate-100 p-4">
    <div class="bg-white rounded-xl p-8 max-w-lg w-full shadow-lg transform transition-all duration-300 hover:shadow-xl">
        <div class="text-center space-y-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">FILAMER CHRISTIAN UNIVERSITY INC.</h2>
                <p class="text-gray-500 text-sm">Asset Management System</p>
            </div>
            
            <div class="flex justify-center p-4 bg-white rounded-lg">
                {{ $qrCode }}
            </div>

            <div class="space-y-2">
                <h2 class="text-xl font-semibold text-gray-700">Asset Tag ID:</h2>
                <p class="text-lg font-mono bg-gray-50 py-2 px-4 rounded-lg inline-block">{{ $asset->asset_tag_id }}</p>
            </div>
        </div>

        <div class="flex justify-between mt-8 gap-4 no-print">
            <button onclick="window.history.back()"
                class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back
            </button>
            
            <button onclick="window.print()"
                class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                Print
            </button>
        </div>
    </div>
</div>
@endsection
