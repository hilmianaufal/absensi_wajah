<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')
            ->latest()
            ->paginate(10);

        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::with('workShift')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|in:present,late,absent,leave,sick',
            'note' => 'nullable|string',
        ]);

        $employee = Employee::with('workShift')->findOrFail($request->employee_id);

        $lateMinutes = 0;
        $status = $request->status;

        if ($request->check_in && $employee->workShift) {
            $shiftStart = Carbon::parse($request->date . ' ' . $employee->workShift->start_time)
                ->addMinutes($employee->workShift->late_tolerance);

            $checkIn = Carbon::parse($request->date . ' ' . $request->check_in);

            if ($checkIn->gt($shiftStart)) {
                $lateMinutes = $checkIn->diffInMinutes($shiftStart);
                $status = 'late';
            }
        }

        Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $status,
            'late_minutes' => $lateMinutes,
            'note' => $request->note,
        ]);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function edit(Attendance $attendance)
{
    $employees = Employee::with('workShift')
        ->where('status', 'active')
        ->orderBy('name')
        ->get();

    return view('attendances.edit', compact('attendance', 'employees'));
}

    public function update(Request $request, Attendance $attendance)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date' => 'required|date',
        'check_in' => 'nullable',
        'check_out' => 'nullable',
        'status' => 'required|in:present,late,absent,leave,sick',
        'note' => 'nullable|string',
    ]);

    $employee = Employee::with('workShift')->findOrFail($request->employee_id);

    $lateMinutes = 0;
    $status = $request->status;

    if ($request->check_in && $employee->workShift) {
        $shiftStart = Carbon::parse($request->date . ' ' . $employee->workShift->start_time)
            ->addMinutes($employee->workShift->late_tolerance);

        $checkIn = Carbon::parse($request->date . ' ' . $request->check_in);

        if ($checkIn->gt($shiftStart)) {
            $lateMinutes = $checkIn->diffInMinutes($shiftStart);
            $status = 'late';
        }
    }

    $attendance->update([
        'employee_id' => $request->employee_id,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'status' => $status,
        'late_minutes' => $lateMinutes,
        'note' => $request->note,
    ]);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Absensi berhasil dihapus.');
    }

    public function faceScan()
    {
        $employees = Employee::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('attendances.face-scan', compact('employees'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'snapshot' => 'required',
        ]);

        $employee = Employee::with('workShift')->findOrFail($request->employee_id);

        $today = now()->toDateString();
        $now = now();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->check_in) {
            return redirect()
                ->route('face-scan')
                ->with('success', 'Karyawan sudah check-in hari ini.');
        }

        $lateMinutes = 0;
        $status = 'present';

        if ($employee->workShift) {

            $shiftStart = Carbon::parse(
                $today . ' ' . $employee->workShift->start_time
            )->addMinutes($employee->workShift->late_tolerance);

            if ($now->gt($shiftStart)) {
                $lateMinutes = $now->diffInMinutes($shiftStart);
                $status = 'late';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE SNAPSHOT
        |--------------------------------------------------------------------------
        */

        $snapshot = $request->snapshot;

        $snapshot = str_replace('data:image/jpeg;base64,', '', $snapshot);
        $snapshot = str_replace(' ', '+', $snapshot);

        $imageName = 'attendance_' . time() . '.jpg';

        $folderPath = public_path('uploads/attendances');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0775, true);
        }

        file_put_contents(
            $folderPath . '/' . $imageName,
            base64_decode($snapshot)
        );

        $photoPath = 'uploads/attendances/' . $imageName;

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => $today,
            'check_in' => $now->format('H:i:s'),
            'status' => $status,
            'late_minutes' => $lateMinutes,
            'photo' => $photoPath,
            'note' => 'Check-in face scanner',
        ]);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Check-in berhasil.');
    }
    
    public function checkOut(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'snapshot' => 'nullable',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $today = now()->toDateString();
        $now = now();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return redirect()
                ->route('face-scan')
                ->with('success', 'Karyawan belum check-in hari ini.');
        }

        $photoPath = $attendance->photo;

        if ($request->snapshot) {
            $snapshot = $request->snapshot;

            $snapshot = str_replace('data:image/jpeg;base64,', '', $snapshot);
            $snapshot = str_replace(' ', '+', $snapshot);

            $imageName = 'checkout_' . time() . '.jpg';

            $folderPath = public_path('uploads/attendances');

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0775, true);
            }

            file_put_contents(
                $folderPath . '/' . $imageName,
                base64_decode($snapshot)
            );

            $photoPath = 'uploads/attendances/' . $imageName;
        }

        $attendance->update([
            'check_out' => $now->format('H:i:s'),
            'photo' => $photoPath,
            'note' => trim(($attendance->note ?? '') . ' | Check-out face scanner'),
        ]);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Check-out berhasil.');
    }

    private function saveSnapshot($base64Image, $prefix = 'scan')
    {
        if (!str_contains($base64Image, ',')) {
            return null;
        }

        [$meta, $image] = explode(',', $base64Image);

        $image = base64_decode($image);

        if (!$image) {
            return null;
        }

        $folder = public_path('uploads/attendances');

        if (!file_exists($folder)) {
            mkdir($folder, 0775, true);
        }

        $filename = $prefix . '_' . time() . '_' . Str::random(10) . '.jpg';

        file_put_contents($folder . '/' . $filename, $image);

        return 'uploads/attendances/' . $filename;
    }

    public function report(Request $request)
    {
        $query = Attendance::with('employee');

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest()->paginate(10)->withQueryString();

        $summaryQuery = clone $query;

        $summary = [
            'present' => (clone $summaryQuery)->where('status', 'present')->count(),
            'late' => (clone $summaryQuery)->where('status', 'late')->count(),
            'leave' => (clone $summaryQuery)->where('status', 'leave')->count(),
            'sick' => (clone $summaryQuery)->where('status', 'sick')->count(),
            'absent' => (clone $summaryQuery)->where('status', 'absent')->count(),
        ];

        return view('attendances.report', compact('attendances', 'summary'));
    }

    public function exportReport(Request $request)
{
    $query = Attendance::with('employee');

    if ($request->filled('start_date')) {
        $query->whereDate('date', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('date', '<=', $request->end_date);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $attendances = $query->latest()->get();

    $filename = 'laporan-absensi-' . date('Y-m-d') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function () use ($attendances) {
        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Nama',
            'Kode Karyawan',
            'Tanggal',
            'Check In',
            'Check Out',
            'Terlambat',
            'Status',
            'Catatan',
        ]);

        foreach ($attendances as $attendance) {
            fputcsv($file, [
                $attendance->employee?->name ?? '-',
                $attendance->employee?->employee_code ?? '-',
                $attendance->date,
                $attendance->check_in ?? '-',
                $attendance->check_out ?? '-',
                $attendance->late_minutes . ' menit',
                $attendance->status,
                $attendance->note ?? '-',
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

    public function descriptors()
{
    $employees = Employee::whereNotNull('face_descriptor')->get();

    $data = $employees->map(function ($employee) {
        return [
            'id' => $employee->id,
            'name' => $employee->name,
            'code' => $employee->employee_code,
            'photo' => $employee->photo ? asset($employee->photo) : null,
            'descriptor' => json_decode($employee->face_descriptor),
        ];
    });

    return response()->json($data);
}

 public function faceRecognitionCheck(Request $request)
{
    try {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'mode' => 'required|in:checkin,checkout',
            'snapshot' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $officeLat = env('OFFICE_LATITUDE');
        $officeLng = env('OFFICE_LONGITUDE');
        $officeRadius = env('OFFICE_RADIUS', 100);

        if (!$officeLat || !$officeLng) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi kantor belum disetting di .env.',
            ], 422);
        }

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $officeLat,
            $officeLng
        );

        if ($distance > $officeRadius) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi ditolak. Lokasi di luar radius kantor. Jarak: ' . round($distance) . ' meter.',
            ], 403);
        }

        $employee = Employee::with('workShift')->findOrFail($request->employee_id);

        $today = now()->toDateString();
        $now = now();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        $snapshotPath = null;

        if ($request->snapshot) {
            $snapshotPath = $this->saveSnapshot($request->snapshot, $request->mode);
        }

        if ($request->mode === 'checkin') {
            if ($attendance && $attendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => $employee->name . ' sudah check-in hari ini.',
                ]);
            }

            $lateMinutes = 0;
            $status = 'present';

            if ($employee->workShift) {
                $shiftStart = \Carbon\Carbon::parse($today . ' ' . $employee->workShift->start_time)
                    ->addMinutes($employee->workShift->late_tolerance);

                if ($now->gt($shiftStart)) {
                    $lateMinutes = $now->diffInMinutes($shiftStart);
                    $status = 'late';
                }
            }

            Attendance::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'date' => $today,
                ],
                [
                    'check_in' => $now->format('H:i:s'),
                    'check_in_photo' => $snapshotPath,
                    'status' => $status,
                    'late_minutes' => $lateMinutes,
                    'photo' => $snapshotPath,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'distance_from_office' => round($distance),
                    'note' => 'Realtime face recognition check-in',
                ]
            );

            return response()->json([
                'success' => true,
                'type' => 'checkin',
                'employee' => $employee->name,
            ]);
        }

        if ($request->mode === 'checkout') {
            if (!$attendance || !$attendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => $employee->name . ' belum check-in hari ini.',
                ]);
            }

            if ($attendance->check_out) {
                return response()->json([
                    'success' => false,
                    'message' => $employee->name . ' sudah check-out hari ini.',
                ]);
            }

            $attendance->update([
                'check_out' => $now->format('H:i:s'),
                'check_out_photo' => $snapshotPath,
                'photo' => $snapshotPath ?? $attendance->photo,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'distance_from_office' => round($distance),
                'note' => trim(($attendance->note ?? '') . ' | Realtime face recognition check-out'),
            ]);

            return response()->json([
                'success' => true,
                'type' => 'checkout',
                'employee' => $employee->name,
            ]);
        }

    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

private function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000;

    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $latDelta = $lat2 - $lat1;
    $lonDelta = $lon2 - $lon1;

    $angle = 2 * asin(sqrt(
        pow(sin($latDelta / 2), 2) +
        cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)
    ));

    return $earthRadius * $angle;
}

public function exportPdf(Request $request)
{
    $query = Attendance::with('employee');

    if ($request->filled('start_date')) {
        $query->whereDate('date', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('date', '<=', $request->end_date);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $attendances = $query->latest()->get();

    $summary = [
        'present' => $attendances->where('status', 'present')->count(),
        'late' => $attendances->where('status', 'late')->count(),
        'leave' => $attendances->where('status', 'leave')->count(),
        'sick' => $attendances->where('status', 'sick')->count(),
        'absent' => $attendances->where('status', 'absent')->count(),
    ];

    $pdf = Pdf::loadView('attendances.report-pdf', compact('attendances', 'summary'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('laporan-absensi-' . date('Y-m-d') . '.pdf');
}


}