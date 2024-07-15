<?php
namespace App\Helpers;

use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SalaryHelper
{
    public static function calculateSalary($user_id, $month, $year)
    {
        $user = User::find($user_id);
        $totalWorkingDays = 22; // Días hábiles estimados en un mes
        $totalSalary = $user->SalarioBase; // Usar SalarioBase
        $afpDeductionRate = 0.03; // 10% de deducción para la AFP

        // Contar las asistencias del empleado en el mes dado
        $totalDaysWorked = Attendance::where('user_id', $user_id)
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->distinct('timestamp')
            ->count();

        $totalDaysMissed = $totalWorkingDays - $totalDaysWorked;

        // Calcular el descuento por falta
        $attendanceRatio = $totalDaysWorked / $totalWorkingDays;
        $missedDaysPenalty = $totalSalary * (1 - $attendanceRatio);

        // Calcular el descuento por AFP
        $afpDiscount = $totalSalary * $afpDeductionRate;

        // Calcular el salario final
        $finalSalary = $totalSalary - $missedDaysPenalty - $afpDiscount;

        Log::info("Salary calculation for user_id: $user_id", [
            'totalSalary' => $totalSalary,
            'finalSalary' => $finalSalary,
            'missedDaysPenalty' => $missedDaysPenalty,
            'afpDiscount' => $afpDiscount,
            'totalDaysWorked' => $totalDaysWorked,
            'totalDaysMissed' => $totalDaysMissed
        ]);

        return [
            'totalSalary' => $totalSalary,
            'finalSalary' => $finalSalary,
            'missedDaysPenalty' => $missedDaysPenalty,
            'afpDiscount' => $afpDiscount,
            'totalDaysWorked' => $totalDaysWorked,
            'totalDaysMissed' => $totalDaysMissed
        ];
    }
}
