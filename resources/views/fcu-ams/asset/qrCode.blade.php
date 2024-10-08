@extends('layouts.layout')
@section('content')
<style>
    body {
        --tw-bg-opacity: 1;
        background-color: rgb(241 245 249 / var(--tw-bg-opacity))
            /* #f1f5f9 */
        ;
    }

    .fcu-icon {
        /* filter: grayscale(100%); */
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
<div class="flex my-auto h-screen">
    <div class="bg-white rounded-lg p-8 max-w-lg shadow-lg my-auto mx-auto">
        <div class="text-center mb-5 flex flex-col">
            <!-- <img class="fcu-icon mb-1 w-28 mx-auto" src="/img/login/fcu-icon.png" alt="" srcset=""> -->
            <h2 class="text-2xl font-bold">FILAMER CHRISTIAN UNIVERSITY INC.</h2>
            <div class="mx-auto my-2">
                {{ $qrCode }}
            </div>
            <h2 class="text-xl font-bold">Asset Tag ID: {{ $asset->asset_tag_id }}</h2>
        </div>
        <div class="flex justify-between mt-5 no-print">
            <button onclick="window.history.back()"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </button>
            <button onclick="window.print()"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    function printReceipt() {
        window.print();
    }
</script>
@endsection
