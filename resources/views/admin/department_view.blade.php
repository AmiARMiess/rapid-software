@extends('layouts.app')

@push('head')
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">View Department</h1>
            <div class="text-muted">Department overview and assigned profile details</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.departments') }}" class="btn btn-light btn-sm shadow-sm mr-2">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            <a class="btn btn-primary btn-sm shadow-sm" href="{{ route('admin.edit.department', request('department_id')) }}" type="button">
                <i class="fa-regular fa-pen-to-square"></i> Edit Department
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Department Name</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $department->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-briefcase fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Position</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countTotalPosition }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Employee</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countTotalEmployee }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-user-tie fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Status</div>
                            {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{ optional($department->optionStatus)->name ?? 'Inactive' }}</div> --}}
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $department->optionStatus?->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-circle-check fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Position Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Created On</label>
                            <div class="form-control-plaintext h6 text-gray-900">{{ $department->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-sm-12">
                            <label class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Description</label>
                            <div class="form-control-plaintext text-gray-800">
                                {{ $department->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Responsibilities</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($department->departmentResponsibles as $departmentResponsibility)
                            <li class="list-group-item">{{ $departmentResponsibility->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection