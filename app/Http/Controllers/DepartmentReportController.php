<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyRequest;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepartmentReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $departmentId = $user->department_id;

        // Date filters for requests
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Get all requests for the department
        $requests = SupplyRequest::with('department')
            ->select(
                'request_group_id',
                'department_id',
                'requester',
                DB::raw('MIN(created_at) as request_date'),
                DB::raw('COUNT(*) as total_items'),
                DB::raw('MAX(status) as group_status'),
                DB::raw('CASE 
                    WHEN MAX(status) = "pending" THEN 1
                    WHEN MAX(status) = "partially_approved" THEN 2
                    WHEN MAX(status) = "approved" THEN 3
                    WHEN MAX(status) = "rejected" THEN 4
                    ELSE 5 END as status_priority')
            )
            ->where('department_id', $departmentId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('request_group_id', 'department_id', 'requester')
            ->orderBy('status_priority', 'asc')
            ->orderBy('request_date', 'desc')
            ->paginate(10);

        // Get statistics
        $totalRequests = SupplyRequest::where('department_id', $departmentId)->distinct('request_group_id')->count();
        $pendingRequests = SupplyRequest::where('department_id', $departmentId)
            ->where('status', 'pending')
            ->distinct('request_group_id')
            ->count();
        $approvedRequests = SupplyRequest::where('department_id', $departmentId)
            ->where('status', 'approved')
            ->distinct('request_group_id')
            ->count();
        $rejectedRequests = SupplyRequest::where('department_id', $departmentId)
            ->where('status', 'rejected')
            ->distinct('request_group_id')
            ->count();
        $cancelledRequests = SupplyRequest::where('department_id', $departmentId)
            ->where('status', 'cancelled')
            ->distinct('request_group_id')
            ->count();

        // Get monthly request trends
        $monthlyTrends = SupplyRequest::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(DISTINCT request_group_id) as count')
        )
            ->where('department_id', $departmentId)
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $trendLabels = $monthlyTrends->pluck('month')->map(function($month) {
            return Carbon::createFromFormat('Y-m', $month)->format('F Y');
        });
        $trendData = $monthlyTrends->pluck('count');

        // Format date range for display
        $dateRangeDisplay = $this->formatDateRange($startDate, $endDate);

        return view('fcu-ams.reports.department-reports', compact(
            'requests',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'cancelledRequests',
            'trendLabels',
            'trendData',
            'dateRangeDisplay',
            'startDate',
            'endDate'
        ));
    }

    private function formatDateRange(Carbon $startDate, Carbon $endDate): string 
    {
        if ($startDate->month == $endDate->month && $startDate->year == $endDate->year) {
            return sprintf(
                "Requests from %s %d %d to %s %d %d",
                $startDate->translatedFormat('F'),
                $startDate->day,
                $startDate->year,
                $endDate->translatedFormat('F'),
                $endDate->day,
                $endDate->year
            );
        }

        return sprintf(
            "Requests from %s %d %d to %s %d %d",
            $startDate->translatedFormat('F'),
            $startDate->day,
            $startDate->year,
            $endDate->translatedFormat('F'),
            $endDate->day,
            $endDate->year
        );
    }
} 