<!DOCTYPE html>
<html>

<head>
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
        }

        body {
            /* background-color: #f4f6f9; */
            color: #333;
            line-height: 1.6;
            padding: 2rem;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul,
        ol {
            list-style: none;
        }

        .monthly-supplier-report {
            background-color: white;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Header Styling */
        .text-center {
            margin-bottom: 2rem;
            border-bottom: 2px solid #3498db;
            padding-bottom: 1rem;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            letter-spacing: 1px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        h3,
        h4 {
            color: #7f8c8d;
            font-size: 1.25rem;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
        }

        thead {
            background-color: #3498db;
            color: white;
        }

        th {
            padding: 0.75rem;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            text-align: left;
            border: 1px solid #2980b9;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }

        td {
            padding: 0.75rem;
            border: 1px solid #e9ecef;
        }

        /* Total Value Styling */
        .total-value {
            background-color: #f1f8ff;
            padding: 1rem;
            border-radius: 4px;
            text-align: right;
            font-size: 1.1rem;
            color: #2980b9;
            margin-top: 1rem;
            font-weight: bold;
        }

        /* Signature Styling */
        .signature {
            margin-top: 2rem;
            text-align: left;
            border-top: 1px solid #e9ecef;
            padding-top: 1rem;
        }

        .signature h4 {
            color: #2c3e50;
            margin-bottom: 0.25rem;
            font-weight: bold;
        }

        .signature p {
            font-style: italic;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="monthly-supplier-report">
        <div class="text-center">
            <h2>FILAMER CHRISTIAN UNIVERSITY, INC</h2>
            <h3>Roxas Avenue, Roxas City</h3>
            <h4>OFFICE SUPPLIES INVENTORY</h4>
            <h4>{{ $startDate }} to {{ $endDate }}</h4>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Unique Tag</th>
                    <th>Items & Specs</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->unique_tag }}</td>
                        <td>{{ $inventory->items_specs }}</td>
                        <td>{{ $inventory->brand->brand }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>{{ number_format($inventory->unit_price, 2) }}</td>
                        <td>{{ number_format($inventory->quantity * $inventory->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-value">
            Total Value: {{ number_format($totalValue, 2) }}
        </div>

        <div class="signature">
            <h4>SHERALYN A. DE LEON</h4>
            <p>Acting - Property Custodian</p>
        </div>
    </div>
</body>

</html>