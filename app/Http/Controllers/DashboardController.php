<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function realtimeData()
    {
        $today = Carbon::today();

        $totalEmployees = Employee::count();

        $presentToday = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'late'])
            ->count();

        $lateToday = Attendance::whereDate('date', $today)
            ->where('status', 'late')
            ->count();

        $checkoutToday = Attendance::whereDate('date', $today)
            ->whereNotNull('check_out')
            ->count();

        $notPresent = max($totalEmployees - $presentToday, 0);

        $activities = Attendance::with('employee')
            ->whereDate('date', $today)
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($attendance) {
                return [
                    'name' => $attendance->employee?->name ?? '-',
                    'code' => $attendance->employee?->employee_code ?? '-',
                    'photo' => $attendance->employee?->photo ? asset($attendance->employee->photo) : null,
                    'check_in' => $attendance->check_in,
                    'check_out' => $attendance->check_out,
                    'status' => $attendance->status,
                ];
            });

        return response()->json([
            'totalEmployees' => $totalEmployees,
            'presentToday' => $presentToday,
            'lateToday' => $lateToday,
            'checkoutToday' => $checkoutToday,
            'notPresent' => $notPresent,
            'activities' => $activities,
        ]);
    }
}