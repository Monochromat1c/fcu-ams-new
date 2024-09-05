@extends('layout.layout')
@section('content')

<section class="min-h-screen bg-gray-100 flex flex-col">
    <div class="bg-blue-700 border-b-2 border-b-blue-900 shadow-2xl p-4 flex justify-between items-center">
        <h1 class="font-bold text-3xl text-amber-400 hover:animate-bounce">Property Custodian</h1>
        <a href="#" class="px-6 py-2 text-white rounded-2xl b bg-red-500 hover:bg-red-400 ease-in transition-all">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            Log Out
        </a>
    </div>
    <div class="mx-auto p-4">
        <h1 class="font-bold text-5xl text text-center mb-5">
            Stock In
        </h1>
        <div class="bg-gray-200 rounded-xl shadow-lg p-5 mb-6">
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="">
                    <p>Item Details:</p>
                    <input type="text" name="" id="" class="bg-white p-2 rounded-xl" style="width:20dvw;">
                </div>
                <div class="">
                    <p>Quantity:</p>
                    <input type="text" name="" id="" class="bg-white p-2 rounded-xl" style="width:20dvw;">
                </div>
                <div class="">
                    <p>Supplier:</p>
                    <input type="text" name="" id="" class="bg-white p-2 rounded-xl" style="width:20dvw;">
                </div>
                <div class="">
                    <p>Date Received:</p>
                    <input type="date" name="" id="" class="bg-white p-2 rounded-xl" style="width:20dvw;">
                </div>
                <div class="">
                    <p>Location:</p>
                    <input type="text" name="" id="" class="bg-white p-2 rounded-xl" style="width:20dvw;">
                </div>
                <div class="">
                    <p>Unit:</p>
                    <input type="text" name="" id="" class="bg-white p-2 rounded-xl" style="width:20dvw;">
                </div>
            </div>
            <div class="flex">
                <div class="flex gap-3 ml-auto">
                    <a href="inventory"
                    class="shadow-xl px-6 py-2 text-white rounded-2xl b bg-red-500 hover:bg-red-400 ease-in transition-all">
                    <i class="fa-solid fa-xmark"></i>
                    Close
                </a>
                <a href="/"
                    class="shadow-xl px-6 py-2 text-white rounded-2xl b bg-green-600 hover:bg-green-500 ease-in transition-all">
                    <i class="fa-regular fa-floppy-disk"></i>
                    Save
                </a>
                </div>
            </div>
        </div>
        
    </div>
</section>

@endsection
