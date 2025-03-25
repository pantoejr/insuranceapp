<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Client;
use App\Models\Insurer;
use App\Models\Policy;
use App\Models\PolicyAssignment;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;


class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $clientCount = Client::count();
        $insurersCount = Insurer::count();
        $policyCount = Policy::count();

        // Claims data
        $pendingClaims = Claim::where('status', 'Pending Review')->count();
        $approvedClaims = Claim::where('status', 'Approved')->count();
        $rejectedClaims = Claim::where('status', 'Rejected')->count();

        // Policy renewals due this month
        $renewalsDue = PolicyAssignment::whereBetween('policy_duration_end', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])->count();

        // Active insurers (assuming you have an 'active' field)
        $activeInsurers = Insurer::where('status', 'active')->count();

        // Monthly policy data (for the bar chart)
        $monthlyPolicies = Policy::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill in missing months with 0
        $allMonths = array_fill(1, 12, 0);
        foreach ($monthlyPolicies as $month => $count) {
            $allMonths[$month] = $count;
        }

        return view('home.index', [
            'clientCount' => $clientCount,
            'insurersCount' => $insurersCount,
            'policyCount' => $policyCount,
            'pendingClaims' => $pendingClaims,
            'approvedClaims' => $approvedClaims,
            'rejectedClaims' => $rejectedClaims,
            'renewalsDue' => $renewalsDue,
            'activeInsurers' => $activeInsurers,
            'monthlyPolicies' => $allMonths,
            'title' => 'Dashboard',
        ]);
    }
}
