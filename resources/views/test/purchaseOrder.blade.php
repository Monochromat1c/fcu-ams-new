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
            Purchase Order
        </h1>
        <div class="bg-gray-400 rounded-xl shadow-lg p-5 mb-6">
            <div class="flex flex-col bg-gray-200 mb-6 p-5 rounded-xl ">
                <div class="flex flex-row space-x-8 justify-between pb-4">
                    <div class="flex flex-row space-x-1  align-items-center">
                        <p class="leading-10">PO Date:</p>
                        <input type="date" name="" id="" class="bg-white p-2 rounded-xl">
                    </div>
                    <div class="flex flex-row space-x-1  align-items-center">
                        <p class="leading-10">PO Number:</p>
                        <input type="text" name="" id="" class="bg-white p-2 rounded-xl">
                        <input type="text" name="" id="" class="bg-white p-2 rounded-xl" style="max-width:40px;">
                        <a href="#" class="bg-amber-600 text-white p-2 rounded-xl">Same with previous PO #</a>
                    </div>
                    <div class="flex flex-row space-x-1  align-items-center">
                        <p class="leading-10">MR Number:</p>
                        <input type="text" name="" id="" class="bg-white p-2 rounded-xl">
                    </div>
                </div>
                <div class="">
                    <div class="flex  space-x-2 align-items-center justify-between mb-4">
                        <p class="leading-10">Requesting Department:</p>
                        <select class="bg-white p-2 rounded-xl flex-1"  name="" id="">
                            <option value="CCS" class="bg-white p-5 rounded-xl">CCS</option>
                            <option value="CCS" class="bg-white p-5 rounded-xl">CAS</option>
                            <option value="CCS" class="bg-white p-5 rounded-xl">CN</option>
                        </select>
                        <p class="leading-10">Supplier:</p>
                        <select class="bg-white p-2 rounded-xl flex-1"  name="" id="">
                            <option value="CCS" class="bg-white p-5 rounded-xl">Oxford</option>
                        </select>
                    </div>
                    <div>
                        <div class="flex  space-x-2 align-items-center justify-between mb-4">
                            <p class="leading-10">Address:</p>
                            <input type="text" name="" id="" class="bg-white p-2 rounded-xl flex-1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 p-5 rounded-xl">
                <table class="min-w-full mb-2">
                    <thead class="">
                        <tr class="">
                            <td class="p-3 text-center">Item No.</td>
                            <td class="p-3 text-center">Quantity</td>
                            <td class="p-3 text-center">Unit</td>
                            <td class="p-3 text-center">Items & Specs</td>
                            <td class="p-3 text-center">Unit Price</td>
                            <td class="p-3 text-center">Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-gray-200">
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-10">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-20">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-20">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl" style="width:60dvh;">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-40">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-40">
                            </td>
                        </tr>
                        <tr class="bg-gray-200">
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-10">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-20">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-20">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl" style="width:60dvh;">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-40">
                            </td>
                            <td class="p-3 text-center">
                                <input type="text" class="bg-white p-2 rounded-xl w-40">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex space-x-2 justify-end">
                    <p class="leading-10">Grand Total:</p>
                    <input type="text" name="" id="" class="bg-white p-2 rounded-xl">
                </div>
            </div>
        </div>
        <div class="flex flex-row justify-between align-end align-items-end">
            <div class="">
                <p class="">Note:</p>
                <textarea name="" id="" class="bg-white p-2 rounded-xl" style="width:60dvh;"></textarea>
            </div>
            <div class="space-x-3">
                <a href="#"
                    class="shadow-xl px-6 py-2 text-white rounded-2xl b bg-green-600 hover:bg-green-500 ease-in transition-all">
                    <i class="fa-regular fa-floppy-disk"></i>
                    Save
                </a>
                <a href="inventory"
                    class="shadow-xl px-6 py-2 text-white rounded-2xl b bg-red-500 hover:bg-red-400 ease-in transition-all">
                    <i class="fa-solid fa-xmark"></i>
                    Close
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
