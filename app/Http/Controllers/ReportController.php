<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function policies($startDate = null, $endDate = null){
        $policies = Policy::all();
        return view('reports.policies',[
            'title' => 'Policy Report',
            'policies' => $policies,
        ]);
    }
}
