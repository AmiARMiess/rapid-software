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
        return view('admin.department_create');
    }

    public function createDepartment(CreateDepartmentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $department = Department::create($data);

        $responsibilities = collect($request->input('responsibilities', []))
            ->filter(fn ($responsibility) => filled($responsibility))
            ->map(fn ($responsibility) => ['name' => trim($responsibility)])
            ->all();

        if (! empty($responsibilities)) {
            $department->positionResponsibles()->createMany($responsibilities);
        }

        return redirect()->route('admin.edit.department', ['department_id' => $department->id])
            ->with('success', 'Department created successfully.');
    }

    public function showEditDepartment(Request $request): View
    {
        $department = Department::where('user_id', auth()->user()->id)
            ->where('id', (int) $request->department_id)
            ->with('departmentResponsibles')
            ->firstOrFail();

        return view('admin.department_edit', compact('department'));
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
        $department = Department::where('user_id', auth()->user()->id)->where('id', (int) $request->department_id)->firstOrFail();

        return view('admin.department_view', compact('department'));
    }

    public function deleteDepartment(Request $request): JsonResponse
    {
        $department = Department::where('id', (int) $request->department_id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $department->delete();

        return response()->json(['success' => true]);
    }
}
