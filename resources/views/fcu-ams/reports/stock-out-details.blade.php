<div class="bg-white rounded-lg shadow-md p-6 lowStock mb-3">
    <h2 class="text-2xl">Stock Out Details</h2>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Item</th>
                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Quantity</th>
                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Price</th>
                <th class="px-4 py-2 text-left bg-slate-100 border border-slate-400">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockOutDetails as $detail)
                <tr>
                    <td class="border border-slate-300 px-4 py-2">{{ $detail['item'] }}</td>
                    <td class="border border-slate-300 px-4 py-2">{{ $detail['quantity'] }}</td>
                    <td class="border border-slate-300 px-4 py-2">{{ $detail['price'] }}</td>
                    <td class="border border-slate-300 px-4 py-2">
                        {{ $detail['quantity'] * $detail['price'] }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="border border-slate-300 px-4 py-2" colspan="3">Total:</td>
                <td class="border border-slate-300 px-4 py-2">{{ $totalPrice }}</td>
            </tr>
        </tbody>
    </table>
</div>