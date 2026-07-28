<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function showEmployee(): View
    {
        return view('admin.employee');
    }

    public function showCreateEmployee(): View
    {
        return view('admin.employee_create');
    }

    public function calculationSocso(Request $request): View
    {
        $validated = $request->validate([
            'monthly_salary' => ['required', 'numeric', 'min:0'],
        ]);

        $monthlySalary = (float) $validated['monthly_salary'];
        $employeeContribution = $this->calculateSocsoEmployeeContribution($monthlySalary);
        $employerContribution = $this->calculateSocsoEmployerContribution($monthlySalary);

        return view('admin.employee_create', [
            'socso' => [
                'monthly_salary' => $monthlySalary,
                'employee_contribution' => $employeeContribution,
                'employer_contribution' => $employerContribution,
                'total_contribution' => round($employeeContribution + $employerContribution, 2),
            ],
        ]);
    }

    protected function calculateSocsoEmployeeContribution(float $monthlySalary): float
    {
        $bracketIndex = $this->socsoBracketIndex($monthlySalary);

        return round(($bracketIndex - 1) * 0.25, 2);
    }

    protected function calculateSocsoEmployerContribution(float $monthlySalary): float
    {
        $bracketIndex = $this->socsoBracketIndex($monthlySalary);
        $contribution = ($bracketIndex - 1) * 0.875;

        return $this->roundToNearestIncrement($contribution, 0.05);
    }

    protected function socsoBracketIndex(float $monthlySalary): int
    {
        return (int) ceil($monthlySalary / 50);
    }

    protected function roundToNearestIncrement(float $value, float $increment): float
    {
        return round($value / $increment) * $increment;
    }

    public function showPayslip() {
        
    }
}
