<div class="monthly-supplier-report">
    <div class="text-center mb-5">
        <h2 class="text-2xl font-bold">FILAMER CHRISTIAN UNIVERSITY, INC</h2>
        <h3 class="text-xl font-bold mb-3 segoe">Roxas Avenue, Roxas City</h3>
        <h3 class="text-xl font-bold segoe">OFFICE SUPPLIES INVENTORY</h3>
        <h4 class="text-lg font-bold segoe">
            {{ $startDate }} - {{ $endDate }}
        </h4>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border text-left p-2">Unique Tag</th>
                <th class="border text-left p-2">Items & Specs</th>
                <th class="border text-left p-2">Brand</th>
                <th class="border text-left p-2">Quantity</th>
                <th class="border text-left p-2">Unit Price</th>
                <th class="border text-left p-2">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
                <tr>
                    <td class="border p-2">{{ $inventory->unique_tag }}</td>
                    <td class="border p-2">{{ $inventory->items_specs }}</td>
                    <td class="border p-2">{{ $inventory->brand->brand }}</td>
                    <td class="border p-2">{{ $inventory->quantity }}</td>
                    <td class="border p-2">₱ {{ number_format($inventory->unit_price, 2) }}</td>
                    <td class="border p-2">
                        ₱ {{ number_format($inventory->quantity * $inventory->unit_price, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 segoe font-bold text-right">Total Value: <span>₱ {{ number_format($totalValue, 2) }}</span>
    </div>

    <div class="mt-4">
        <h4 class="font-bold segoe">SHERALYN A. DE LEON</h4>
        <p class="italic">Acting - Property Custodian</p>
    </div>
</div>