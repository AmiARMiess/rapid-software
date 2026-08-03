@extends('layouts.app')

@push('head')
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Leave</h1>

        <a href="{{ route('admin.create.leave') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fa-solid fa-plus"></i> Add Leave</a>
    </div>
@endsection


@push('script')
@endpush
