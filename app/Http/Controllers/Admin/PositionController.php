<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePositionRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\OptionLevel;
use App\Models\OptionStatus;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Requests\UpdatePositionRequest;

class PositionController extends Controller
{
    public function showPosition(): View
    {
        return view('admin.position');
    }

    public function positionDatatable(Request $request)
    {
        $query = Position::query()->where('user_id', auth()->user()->id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
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
            ->skip(($page - 1) * $itemsPerPage)
            ->take($itemsPerPage)
            ->get()
            ->values();

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }
    
    public function showCreatePosition(): View
    {
        $departments = Department::where('user_id', auth()->user()->id)->get();
        $positions = Position::where('user_id', auth()->user()->id)->get();
        $optionStatuses = OptionStatus::all();
        $optionLevels = OptionLevel::all();

        return view('admin.position_create', compact('departments', 'positions', 'optionStatuses', 'optionLevels'));
    }

    public function createPosition(CreatePositionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $position = Position::create($data);

        $responsibilities = collect($request->input('responsibilities', []))
            ->filter(fn ($responsibility) => filled($responsibility))
            ->map(fn ($responsibility) => ['name' => trim($responsibility)])
            ->all();

        if (! empty($responsibilities)) {
            $position->positionResponsibles()->createMany($responsibilities);
        }

        return redirect()->route('admin.edit.position', ['position_id' => $position->id])
            ->with('success', 'Position created successfully.');
    }

    public function showEditPosition(Request $request): View
    {
        $departments = Department::where('user_id', auth()->user()->id)
            ->get();

        $position = Position::where('id', $request->position_id)
            ->where('user_id', auth()->user()->id)
            ->with('positionResponsibles')
            ->firstOrFail();

        $positions = Position::where('user_id', auth()->user()->id)
            ->get();

        $countTotalPosition = Employee::where('user_id', auth()->user()->id)
            ->where('position', $request->position_id)
            ->count();

        $optionStatuses = OptionStatus::all();
        $optionLevels = OptionLevel::all();

        return view('admin.position_edit', compact('departments', 'position', 'positions', 'optionStatuses', 'optionLevels', 'countTotalPosition'));
    }

    public function updatePosition(UpdatePositionRequest $request): RedirectResponse
    {        
        $position = Position::where('id', (int) $request->position_id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $validated = $request->validated();

        $position->update($validated);

        $position->positionResponsibles()->delete();

        $responsibilities = collect($request->input('responsibilities', []))
            ->filter(fn($responsibility) => filled($responsibility))
            ->map(fn($responsibility) => ['name' => trim($responsibility)])
            ->all();

        if (! empty($responsibilities)) {
            $position->positionResponsibles()->createMany($responsibilities);
        }

        return redirect()->route('admin.edit.position', ['position_id' => $position->id])
            ->with('success', 'Position updated successfully.');
    }

    public function showViewPosition(Request $request): View
    {
        $position = Position::where('user_id', auth()->user()->id)->where('id', (int) $request->position_id)->firstOrFail();
        $countTotalPosition = Employee::where('position', (int) $request->position_id)->where('user_id', auth()->user()->id)->count();

        return view('admin.position_view', compact('position' ,'countTotalPosition'));
    }

    public function deletePosition(Request $request): JsonResponse
    {
        $position = Position::where('id', (int) $request->position_id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $position->delete();

        return response()->json(['success' => true]);
    }
}
