<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #4CAF50; /* PSU Green */
            margin-bottom: 10px;
            font-size: 18px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .header-info img {
            width: 80px; /* Adjust as needed */
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .no-requests {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }
        .status-pending { color: #f0ad4e; }
        .status-approved { color: #5cb85c; }
        .status-denied { color: #d9534f; }
        .status-pending_return_approval { color: #337ab7; }
        .status-returned { color: #777; }
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
            <div>User: {{ $user->name }} ({{ $user->email }})</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Req. ID</th>
                    <th>Item Name</th>
                    <th>Property #</th>
                    <th>Qty. Req.</th>
                    <th>Date Requested</th>
                    <th>Status</th>
                    <th>Date Processed</th>
                    <th>Processed By</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td class="text-center">#{{ $request->id }}</td>
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
                        <td>{{ Str::limit($request->remarks, 50) ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="no-requests">No transactions found for this period or user.</td>
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