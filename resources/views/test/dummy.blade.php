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
    <div class="lg:container mx-auto p-4">
        <h1 class="font-bold text-5xl text text-center mb-5">
            Inventory
        </h1>
        <table class="min-w-full mb-2 shadow-xl">
            <thead class="">
                <tr class="bg-blue-600 text-white">
                    <td class="p-3 text-center">Item No.</td>
                    <td class="p-3 text-center">Quantity</td>
                    <td class="p-3 text-center">Unit</td>
                    <td class="p-3 text-center">Items & Specs</td>
                    <td class="p-3 text-center">Unit Price</td>
                    <td class="p-3 text-center">Supplier</td>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-gray-200">
                    <td class="p-3 text-center">1</td>
                    <td class="p-3 text-center">3</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">Office Chair</td>
                    <td class="p-3 text-center">1250</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-white">
                    <td class="p-3 text-center">2</td>
                    <td class="p-3 text-center">2</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">Icon Monitor</td>
                    <td class="p-3 text-center">2120</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-gray-200">
                    <td class="p-3 text-center">3</td>
                    <td class="p-3 text-center">3</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">Nvision Frameless Monitor</td>
                    <td class="p-3 text-center">3550</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-white">
                    <td class="p-3 text-center">4</td>
                    <td class="p-3 text-center">3</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">Hyperion Classic Mouse</td>
                    <td class="p-3 text-center">1100</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-gray-200">
                    <td class="p-3 text-center">5</td>
                    <td class="p-3 text-center">5</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">HyperionX Gaming Mouse</td>
                    <td class="p-3 text-center">1500</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-white">
                    <td class="p-3 text-center">6</td>
                    <td class="p-3 text-center">3</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">HyperionX Wireless Mouse</td>
                    <td class="p-3 text-center">1950</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-gray-200">
                    <td class="p-3 text-center">7</td>
                    <td class="p-3 text-center">4</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">Zoltraak Mechanical Keyboard</td>
                    <td class="p-3 text-center">1599</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-white">
                    <td class="p-3 text-center">8</td>
                    <td class="p-3 text-center">100</td>
                    <td class="p-3 text-center">pcs.</td>
                    <td class="p-3 text-center">Bond Paper - Short</td>
                    <td class="p-3 text-center">2</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-gray-200">
                    <td class="p-3 text-center">9</td>
                    <td class="p-3 text-center">100</td>
                    <td class="p-3 text-center">pcs.</td>
                    <td class="p-3 text-center">Bond Paper - Long</td>
                    <td class="p-3 text-center">5</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
                <tr class="bg-white">
                    <td class="p-3 text-center">10</td>
                    <td class="p-3 text-center">5</td>
                    <td class="p-3 text-center">units</td>
                    <td class="p-3 text-center">AOC Monitor</td>
                    <td class="p-3 text-center">1350</td>
                    <td class="p-3 text-center">Oxford</td>
                </tr>
            </tbody>
        </table>
        <div class="flex flex-row justify-between mt-5">
            <div class="space-x-2">
                <a href="stock-in"
                    class="shadow-xl px-6 py-2 text-white rounded-2xl b bg-green-600 hover:bg-green-500 ease-in transition-all">
                    Stock In
                </a>
                <a href="stock-out"
                    class="shadow-xl px-6 py-2 text-white rounded-2xl b bg-amber-600 hover:bg-amber-500 ease-in transition-all">
                    Stock Out
                </a>
            </div>
            <div>
                <a href="purchase-order"
                    class="shadow-xl px-6 py-2 text-white rounded-2xl b bg-blue-500 hover:bg-blue-400 ease-in transition-all">
                    Purchase Order
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
