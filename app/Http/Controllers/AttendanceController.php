<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|string|max:255',
        ]);
        $employee = Employee::where('employee_id', $request->employee_id)->first();

        if (!$employee) {
            return redirect()->route('welcome')->withErrors(['employee_id' => 'El código de empleado no está registrado.']);
        }
        Attendance::create([
            'employee_id' => $employee->id,
            'timestamp' => now(),
        ]);
        return redirect()->route('welcome')->with([
                'status' => 'Asistencia registrada con éxito',
                'employee_name' => $employee->name
            ]);

    }
}
