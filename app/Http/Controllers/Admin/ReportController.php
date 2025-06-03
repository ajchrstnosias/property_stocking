<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Show the form for generating the transaction report.
     */
    public function transactionsReportForm()
    {
        return view('admin.reports.transactions_form');
    }

    /**
     * Generate and download a PDF report of all transactions based on date filters.
     */
    public function downloadTransactionsReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : null;

        $query = ItemRequest::with(['item', 'user', 'processedBy'])->orderBy('created_at', 'desc');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        $requests = $query->get();

        $data = [
            'title' => ' Property Stocking Transaction Report',
            'date' => date('m/d/Y'),
            'requests' => $requests,
            'startDate' => $startDate ? $startDate->format('m/d/Y') : 'All Time',
            'endDate' => $endDate ? $endDate->format('m/d/Y') : 'All Time',
        ];

        $pdf = Pdf::loadView('pdf.admin_transactions_report', $data);

        $fileName = 'property_history_report_' . date('YmdHis') . '.pdf';
        return $pdf->download($fileName);
    }
} 