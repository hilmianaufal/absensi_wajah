<?php

namespace App\Http\Controllers;

use App\Models\WorkShift;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    public function index()
    {
        $workShifts = WorkShift::latest()->paginate(10);

        return view('work-shifts.index', compact('workShifts'));
    }

    public function create()
    {
        return view('work-shifts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'late_tolerance' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        WorkShift::create($request->all());

        return redirect()
            ->route('work-shifts.index')
            ->with('success', 'Shift berhasil ditambahkan.');
    }

    public function edit(WorkShift $workShift)
    {
        return view('work-shifts.edit', compact('workShift'));
    }

    public function update(Request $request, WorkShift $workShift)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'late_tolerance' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $workShift->update($request->all());

        return redirect()
            ->route('work-shifts.index')
            ->with('success', 'Shift berhasil diperbarui.');
    }

    public function destroy(WorkShift $workShift)
    {
        $workShift->delete();

        return redirect()
            ->route('work-shifts.index')
            ->with('success', 'Shift berhasil dihapus.');
    }
}