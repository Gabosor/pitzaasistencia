<?php
namespace App\Helpers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceHelper
{
    public static function calculateHoursAndDelays($user_id, $date)
    {
        $attendances = Attendance::where('user_id', $user_id)
                                  ->whereDate('timestamp', $date)
                                  ->orderBy('timestamp')
                                  ->get();

        // Verificamos que estamos obteniendo los registros correctos
        if ($attendances->isEmpty()) {
            Log::info("No attendance records found for user_id: $user_id on date: $date");
            return ['hours' => 0, 'delays' => 0];
        }

        $expectedEntryTime = Carbon::createFromTime(8, 30);
        $totalWorkedHours = 0;
        $totalDelayMinutes = 0;
        $entryTime = null;

        foreach ($attendances as $attendance) {
            if ($attendance->status == 'in') {
                $entryTime = Carbon::parse($attendance->timestamp);
                Log::info("Entry time for user_id: $user_id on date: $date is $entryTime");
                if ($entryTime->greaterThan($expectedEntryTime)) {
                    $delayMinutes = $entryTime->diffInMinutes($expectedEntryTime);
                    $totalDelayMinutes += $delayMinutes;
                }
            } elseif ($attendance->status == 'out' && $entryTime) {
                $exitTime = Carbon::parse($attendance->timestamp);
                $workedHours = $exitTime->diffInHours($entryTime);
                $totalWorkedHours += $workedHours;
                Log::info("Exit time for user_id: $user_id on date: $date is $exitTime. Worked hours: $workedHours");
                $entryTime = null; // Reset entryTime after calculating worked hours
            } else {
                Log::info("Skipping attendance record with status: $attendance->status for user_id: $user_id on date: $date");
            }

            // Debug output for each attendance record
            Log::info('Attendance Record', [
                'user_id' => $user_id,
                'timestamp' => $attendance->timestamp,
                'status' => $attendance->status,
                'entryTime' => $entryTime,
                'totalWorkedHours' => $totalWorkedHours,
                'totalDelayMinutes' => $totalDelayMinutes
            ]);
        }

        return ['hours' => $totalWorkedHours, 'delays' => $totalDelayMinutes];
    }
}
