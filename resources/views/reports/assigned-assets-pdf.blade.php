<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Assigned Assets Report</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            margin-bottom: 9px;
            position: relative;
            min-height: 100px;
            text-align: center;  /* Center all content */
        }
        .header-content {
            display: inline-block;
            width: 70%;
            padding-top: 20px;  /* Add some top padding to align with logo */
        }
        .report-title {
            font-size: 18px;  /* Increased font size */
            font-weight: bold;
            margin-bottom: 6px;
        }
        .report-info {
            font-size: 12pt;
            line-height: 1.5;  /* Add some line spacing */
        }
        .report-info p {
            margin: 5px 0;  /* Adjust paragraph spacing */
        }
        .logo {
            position: absolute;
            top: 6;
            left: 70px;
            width: 100px;
            height: auto;
        }
        .report-info {
            font-size: 14px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .summary {
            margin-top: 20px;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #666;
        }
        td:last-child {
            text-align: right;
            padding-right: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="report-title">Assigned Assets Report</div>
            <div class="report-info">
                <p>Assignee: {{ $assignee }}</p>
                <p>Report Generated: {{ $currentDate }}</p>
            </div>
        </div>
        <img src="{{ public_path('img/login/fcu-icon.png') }}" alt="FCU Icon" class="logo">
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 11%">Asset Tag ID</th>
                <th style="width: 10%">Brand</th>
                <th style="width: 11%">Model</th>
                <th style="width: 13%">Serial Number</th>
                <th style="width: 15%">Department</th>
                <th style="width: 13%">Site</th>
                <th style="width: 9%">Status</th>
                <th style="width: 9%">Condition</th>
                <th style="width: 9%">Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->asset_tag_id }}</td>
                    <td>{{ $asset->brand->brand }}</td>
                    <td>{{ $asset->model }}</td>
                    <td>{{ $asset->serial_number }}</td>
                    <td>{{ $asset->department->department }}</td>
                    <td>{{ $asset->site->site }}</td>
                    <td>{{ $asset->status->status }}</td>
                    <td>{{ $asset->condition->condition }}</td>
                    <td>{{ number_format($asset->cost, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Total Number of Assets:</strong> {{ $assets->count() }}</p>
        <p><strong>Total Value:</strong> PHP {{ number_format($totalValue, 2) }}</p>
    </div>
</body>
</html> 