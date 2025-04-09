<?php

namespace App\Http\Controllers;

use App\Models\SmsLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SmsLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $smsLogs = SmsLog::all();
        return view('sms_logs.index', [
            'title' => 'SMS Logs',
            'smsLogs' => $smsLogs,
        ]);
    }
}
