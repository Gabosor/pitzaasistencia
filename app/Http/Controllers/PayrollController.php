<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\SalaryHelper;
use Dompdf\Dompdf;
use Dompdf\Options;

class PayrollController extends Controller
{
     public function generatePayrollPDF($month, $year)
    {
        $employees = User::all();
        $payrollData = [];

        foreach ($employees as $employee) {
            $salaryData = SalaryHelper::calculateSalary($employee->id, $month, $year);
            $payrollData[] = [
                'name' => $employee->name,
                'totalSalary' => $salaryData['totalSalary'],
                'finalSalary' => $salaryData['finalSalary'],
                'missedDaysPenalty' => $salaryData['missedDaysPenalty'],
                'afpDiscount' => $salaryData['afpDiscount'],
                'totalDaysWorked' => $salaryData['totalDaysWorked'],
                'totalDaysMissed' => $salaryData['totalDaysMissed']
            ];
        }

        $html = view('payroll', ['payrollData' => $payrollData, 'month' => $month, 'year' => $year])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('planilla_sueldos.pdf', ['Attachment' => true]);
    }
}
