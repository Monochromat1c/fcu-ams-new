@extends('layouts.layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/stockin.css') }}">


<div class="grid grid-cols-6">
    @include('layouts.sidebar')
    <div class="content min-h-screen bg-slate-100 col-span-5">
        <nav class="m-3 mt-6">
            <h1 class="text-center text-4xl">Stock Out</h1>
        </nav>
        <div class="stockout-form bg-white m-3 shadow-md rounded-md p-5">
            <form method="POST" action="{{ route('inventory.stock.out.store') }}">
                @csrf
                <div class="">
                    @if(session('success'))
                        <div
                            class="successMessage bg-green-100 border border-green-400 text-black px-4 py-3 rounded
                            relative mt-2 mb-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-black px-4 py-3 rounded relative mt-2 mb-2">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h3 class="text-lg font-semibold mb-3">Item Details</h3>
                    <div class="mb-4">
                        <label for="item_id" class="block text-gray-700 font-bold mb-2">Item:</label>
                        <button type="button" class="ml-auto rounded-md border text-left px-3 py-2  text-black w-full"
                            onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                            Select Items
                        </button>
                    </div>
                    <div class="flex mx-auto my-auto">
                        <!-- <div id="defaultModal" tabindex="-1" aria-hidden="true"
                            class="fixed top-0 left-0 right-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full hidden"> -->
                        <div id="defaultModal" tabindex="-1" aria-hidden="true"
                            class="hidden">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-lg dark:bg-slate-100">
                                    <button type="button"
                                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                        onclick="document.getElementById('defaultModal').classList.toggle('hidden')">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <h2 class="mb-4 text-lg font-bold text-black">Select Items to
                                            Stock Out</h2>
                                        <div class="overflow-y-auto h-96">
                                            @foreach($inventories as $inventory)
                                                <div class="flex items-center mb-2 mt-2">
                                                    <input type="checkbox" id="item_id_{{ $inventory->id }}"
                                                        name="item_id[]" value="{{ $inventory->id }}">
                                                    <label for="item_id_{{ $inventory->id }}"
                                                        class="mx-2">{{ $inventory->brand }}
                                                        {{ $inventory->items_specs }} ({{ $inventory->quantity }}
                                                        available, {{ $inventory->unit_price }}
                                                        {{ $inventory->unit->unit }})</label>
                                                    <input type="number" id="quantity_{{ $inventory->id }}"
                                                        name="quantity[]" class="w-full p-2 border rounded-md mr-2"
                                                        placeholder="Enter the quantity">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="department_id" class="block text-gray-700 font-bold mb-2">Department:</label>
                        <select id="department_id" name="department_id" class="w-full p-2 border rounded-md" required>
                            <option value="">Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="stock_out_date" class="block text-gray-700 font-bold mb-2">Stock Out Date:</label>
                        <input type="date" id="stock_out_date" name="stock_out_date"
                            class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="receiver" class="block text-gray-700 font-bold mb-2">Received by:</label>
                        <input type="input" id="receiver" name="receiver" class="w-full p-2 border rounded-md"
                            required>
                    </div>
                </div>
                <div class="space-x-2 flex">
                    <!-- <button type="button" class="ml-auto rounded-md shadow-md px-5 py-2 bg-red-600 hover:shadow-md hover:bg-red-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white"
                        onclick="history.back()">Back</button> -->
                    <button type="submit" class="ml-auto rounded-md shadow-md px-5 py-2 bg-green-600 hover:shadow-md hover:bg-green-500
                        transition-all duration-200 hover:scale-105 ease-in hover:shadow-inner text-white">Stock
                        Out</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = document.querySelector('.successMessage');

        if (successMessage) {
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 2000);
        }
    });
</script>
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
