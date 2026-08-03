<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\OptionGender;
use App\Models\OptionBankName;
use App\Models\OptionReligion;
use App\Models\OptionMaritalStatus;
use App\Models\OptionEmploymentType;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function showEmployee(): View
    {
        $employees = Employee::get();

        return view('admin.employee', compact('employees'));
    }

    public function showCreateEmployee(): View
    {
        $optionGenders = OptionGender::all();
        $optionBankNames = OptionBankName::all();
        $optionReligions = OptionReligion::all();
        $optionMaritalStatuses = OptionMaritalStatus::all();
        $optionEmploymentTypes = OptionEmploymentType::all();

        return view('admin.employee_create', compact(
            'optionGenders',
            'optionBankNames',
            'optionReligions',
            'optionMaritalStatuses',
            'optionEmploymentTypes'
        ));
    }

    public function calculationSocso(Request $request)
    {
        // $validated = $request->validate([
        //     'monthly_salary' => ['required', 'numeric', 'min:0'],
        // ]);

        // $monthlySalary = (float) $validated['monthly_salary'];
        $monthlySalary = (float) 1800;
        $employeeContribution = $this->calculateSocsoEmployeeContribution($monthlySalary);
        $employerContribution = $this->calculateSocsoEmployerContribution($monthlySalary);

        dump($employeeContribution);

        // return view('admin.employee_create', [
        //     'socso' => [
        //         'monthly_salary' => $monthlySalary,
        //         'employee_contribution' => $employeeContribution,
        //         'employer_contribution' => $employerContribution,
        //         'total_contribution' => round($employeeContribution + $employerContribution, 2),
        //     ],
        // ]);
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

    public function employeeDatatable(Request $request)
    {
        $query = Employee::query()->where('user_id', auth()->user()->id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                ->orWhere('employee_number', 'like', "%{$search}%")
                ->orWhere('passport_number', 'like', "%{$search}%")
                ->orWhere('ic_number', 'like', "%{$search}%");
                    // ->orWhereHas('optionGender', function ($optionGenderQuery) use ($search) {
                    //     $optionGenderQuery->where('gender', 'like', "%{$search}%");
                    // });
            });
        }

        $sortBy = json_decode($request->get('sortBy', '[]'), true);

        if (is_array($sortBy) && ! empty($sortBy)) {
            $sort = $sortBy[0];

            if (isset($sort['key']) && isset($sort['order'])) {
                $query->orderBy($sort['key'], $sort['order'] === 'desc' ? 'desc' : 'asc');
            }
        }

        $page = (int) $request->get('page', 1);
        $itemsPerPage = (int) $request->get('itemsPerPage', 5);

        $total = $query->count();

        $items = $query
            // ->with('optionGender:id,gender')
            ->skip(($page - 1) * $itemsPerPage)
            ->take($itemsPerPage)
            ->get()
            // ->map(function (Employee $employee) {
            //     return [
            //         ...$employee->toArray(),
            //         'gender' => $employee->optionGender?->gender ?? $employee->gender,
            //         'gender_id' => (int) $employee->gender,
            //     ];
            // })
            ->values();

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function showPayslip()
    {

        Pdf::view('admin.pdf.payslip')
            ->format('a4')
            ->save('invoice.pdf');
    }
}
