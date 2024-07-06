<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|max:255',
        ]);
        $employee = User::where('ci', $request->ci)->first();

        if (!$employee) {
            return redirect()->route('welcome')->withErrors(['ci' => 'El código de empleado no está registrado.']);
        }
        Attendance::create([
            'user_id' => $employee->id,
            'timestamp' => now(),
        ]);
        return redirect()->route('welcome')->with([
                'status' => 'Asistencia registrada con éxito',
                'employee_name' => $employee->nombres." ".$employee->apellidos
            ]);

    }
}
