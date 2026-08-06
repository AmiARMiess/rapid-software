<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Department;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\OptionStatus;
use App\Models\Position;
use App\Models\Employee;

class DepartmentController extends Controller
{
    public function showDepartment(): View
    {
        return view('admin.department');
    }

    public function departmentDatatable(Request $request)
    {
        $query = Department::query()->where('user_id', auth()->user()->id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
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
            ->skip(($page - 1) * $itemsPerPage)
            ->take($itemsPerPage)
            ->get()
            ->values();

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function showCreateDepartment(): View
    {
        $optionStatuses = OptionStatus::all();

        return view('admin.department_create', compact('optionStatuses'));
    }

    public function createDepartment(CreateDepartmentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $department = Department::create($data);

        $responsibilities = collect($request->input('responsibilities', []))
            ->filter(fn($responsibility) => filled($responsibility))
            ->map(fn($responsibility) => ['name' => trim($responsibility)])
            ->all();

        if (! empty($responsibilities)) {
            $department->departmentResponsibles()->createMany($responsibilities);
        }

        return redirect()->route('admin.edit.department', ['department_id' => $department->id])
            ->with('success', 'Department created successfully.');
    }

    public function showEditDepartment(Request $request): View
    {
        $department = Department::where('user_id', auth()->user()->id)
            ->where('id', (int) $request->department_id)
            ->with('departmentResponsibles')
            ->withCount(['employees as employees_count' => function ($query) {
                $query->where('employees.user_id', auth()->id());
            }])
            ->firstOrFail();

        $countTotalPosition = Position::where('department', (int) $request->department_id)
            ->where('user_id', auth()->user()->id)
            ->count();

        $countTotalEmployee = $department->employees_count;

        $optionStatuses = OptionStatus::all();

        return view('admin.department_edit', compact('department', 'optionStatuses', 'countTotalPosition', 'countTotalEmployee'));
    }

    public function updateDepartment(UpdateDepartmentRequest $request): RedirectResponse
    {
        $department = Department::where('id', (int) $request->department_id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $validated = $request->validated();

        $department->update($validated);

        $department->departmentResponsibles()->delete();

        $responsibilities = collect($request->input('responsibilities', []))
            ->filter(fn($responsibility) => filled($responsibility))
            ->map(fn($responsibility) => ['name' => trim($responsibility)])
            ->all();

        if (! empty($responsibilities)) {
            $department->departmentResponsibles()->createMany($responsibilities);
        }

        return redirect()->route('admin.edit.department', ['department_id' => $department->id])
            ->with('success', 'Department updated successfully.');
    }

    public function showViewDepartment(Request $request): View
    {
        $department = Department::where('user_id', auth()->user()->id)
            ->where('id', (int) $request->department_id)
            ->with('departmentResponsibles')
            ->withCount(['employees as employees_count' => function ($query) {
                $query->where('employees.user_id', auth()->id());
            }])
            ->firstOrFail();

        $countTotalPosition = Position::where('department', (int) $request->department_id)
            ->where('user_id', auth()->user()->id)
            ->count();

        $countTotalEmployee = $department->employees_count;

        return view('admin.department_view', compact('department', 'countTotalPosition', 'countTotalEmployee'));
    }

    public function deleteDepartment(Request $request): JsonResponse
    {
        $department = Department::where('id', (int) $request->department_id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $department->delete();

        return response()->json(['success' => true]);
    }

    public function printDepartment(Request $request)
    {
        $department = Department::where('user_id', auth()->user()->id)
            ->where('id', (int) $request->department_id)
            ->with('departmentResponsibles')
            ->withCount(['employees as employees_count' => function ($query) {
                $query->where('employees.user_id', auth()->id());
            }])
            ->firstOrFail();

        $countTotalPosition = Position::where('department', (int) $request->department_id)
            ->where('user_id', auth()->user()->id)
            ->count();

        $countTotalEmployee = $department->employees_count;

        $pdfFileName = "departments/department-{$department->id}.pdf";

        // Render the Blade view to HTML first so we can verify variables are present
        $html = view('admin.pdf.department_info', compact('department', 'countTotalPosition', 'countTotalEmployee'))->render();

        // Save debug HTML (optional) to the private storage so you can inspect the rendered HTML
        try {
            \Illuminate\Support\Facades\Storage::disk('local')->put("departments/department-{$department->id}.html", $html);
        } catch (\Throwable $e) {
            // ignore write failures for debug file
        }

        // Generate the PDF from rendered HTML to avoid any view rendering issues inside the PDF driver
        Pdf::html($html)
            ->name("department-{$department->id}.pdf")
            ->disk('local', 'private')
            ->save($pdfFileName);

        $pdfPath = storage_path('app/private/'.$pdfFileName);

        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="department-{$department->id}.pdf"',
        ]);
    }
}
