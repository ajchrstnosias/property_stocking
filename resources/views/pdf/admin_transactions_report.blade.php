<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px; /* Smaller font for more data */
            line-height: 1.3;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 15px;
        }
        h1 {
            text-align: center;
            color: #1E3A8A; /* PSU Dark Blue */
            margin-bottom: 8px;
            font-size: 16px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
        }
        .header-info img {
            width: 70px; /* Adjust as needed */
            margin-bottom: 5px;
        }
        .filter-info {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
            word-wrap: break-word; /* Allow long text to wrap */
        }
        th {
            background-color: #e9e9e9;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            text-align: center;
            font-size: 9px;
            color: #777;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
        .no-requests {
            text-align: center;
            padding: 15px;
            font-style: italic;
        }
        .status-pending { color: #f0ad4e; font-weight: bold; }
        .status-approved { color: #5cb85c; font-weight: bold; }
        .status-denied { color: #d9534f; font-weight: bold; }
        .status-pending_return_approval { color: #337ab7; font-weight: bold; }
        .status-returned { color: #777; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-info">
            <img src="{{ public_path('images/psu_logo.png') }}" alt="PSU Logo">
            <div>Pangasinan State University - Urdaneta Campus</div>
            <div>Property Stocking System</div>
            <h1>{{ $title }}</h1>
            <div>Report Generated on: {{ $date }}</div>
        </div>

        <div class="filter-info">
            Date Range: {{ $startDate }} - {{ $endDate }}
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">Req.ID</th>
                    <th style="width: 15%;">Requester</th>
                    <th style="width: 15%;">Item Name</th>
                    <th style="width: 10%;">Property #</th>
                    <th style="width: 5%;">Qty.</th>
                    <th style="width: 10%;">Date Requested</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Date Processed</th>
                    <th style="width: 10%;">Processed By</th>
                    <th style="width: 11%;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td class="text-center">#{{ $request->id }}</td>
                        <td>{{ $request->user->name ?? 'N/A' }} <br><small>({{ $request->user->email ?? 'N/A' }})</small></td>
                        <td>{{ $request->item->name ?? 'N/A' }}</td>
                        <td>{{ $request->item->property_number ?? 'N/A' }}</td>
                        <td class="text-center">{{ $request->requested_quantity }}</td>
                        <td>{{ $request->created_at->format('m/d/Y H:i') }}</td>
                        <td>
                            <span class="status-{{ strtolower(str_replace(' ', '_', $request->status)) }}">
                                {{ ucwords(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </td>
                        <td>{{ $request->processed_at ? $request->processed_at->format('m/d/Y H:i') : 'N/A' }}</td>
                        <td>{{ $request->processedBy->name ?? 'N/A' }}</td>
                        <td>{{ $request->remarks ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="no-requests">No transactions found for the selected criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Property Stocking System - PSU Urdaneta Campus &copy; {{ date('Y') }}

            <div class="system-info"><strong>Osias</strong> - Elective1 - 2025 - Villanueva</div>
        </div>
    </div>
</body>
</html> 