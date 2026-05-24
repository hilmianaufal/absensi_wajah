<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\WorkShift;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query()->with('workShift');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $employees = $query->latest()->paginate(10);

        $departments = Employee::whereNotNull('department')
            ->where('department', '!=', '')
            ->select('department')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        if ($request->ajax()) {
            return view('employees.partials.table', compact('employees'))->render();
        }

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $workShifts = WorkShift::where('status', 'active')->get();

        return view('employees.create', compact('workShifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'work_shift_id' => 'nullable|exists:work_shifts,id',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            $filename = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();

            $photo->move(public_path('uploads/employees'), $filename);

            $data['photo'] = 'uploads/employees/' . $filename;
        }

        Employee::create($data);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $workShifts = WorkShift::where('status', 'active')->get();

        return view('employees.edit', compact('employee', 'workShifts'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code,' . $employee->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'work_shift_id' => 'nullable|exists:work_shifts,id',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($employee->photo && file_exists(public_path($employee->photo))) {
                unlink(public_path($employee->photo));
            }

            $photo = $request->file('photo');

            $filename = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();

            $photo->move(public_path('uploads/employees'), $filename);

            $data['photo'] = 'uploads/employees/' . $filename;
        }

        $employee->update($data);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->photo && file_exists(public_path($employee->photo))) {
            unlink(public_path($employee->photo));
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }

    public function faceRegister(Employee $employee)
    {
        return view('employees.face-register', compact('employee'));
    }

    public function saveFaceDescriptor(Request $request, Employee $employee)
    {
        $request->validate([
            'face_descriptor' => 'required|string',
        ]);

        $employee->update([
            'face_descriptor' => $request->face_descriptor,
        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data wajah berhasil diregistrasi.');
    }
}