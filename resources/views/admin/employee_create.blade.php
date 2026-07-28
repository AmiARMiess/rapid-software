@extends('layouts.app')

@push('head')
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="pb-3">Record a new employee</div>

    <div class="row">
        <div class="col-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#personalInformationCard" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="personalInformationCard">
                    <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="personalInformationCard" style="">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control form-control-user" id="fullName" placeholder="">
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="icNumber">IC Number</label>
                                <input type="text" class="form-control form-control-user" id="icNumber"
                                    placeholder="890211-14-1234">
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender">
                                        <option>Select...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="religion">Religion</label>
                                    <select class="form-control" id="religion">
                                        <option>Select...</option>
                                        <option>Islam</option>
                                        <option>Hindu</option>
                                        <option>Buddhist</option>
                                        <option>Christian</option>
                                        <option>Other</option>
                                    </select>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="dateOfBirth">Date of Birth</label>
                                    <input type="date" class="form-control form-control-user" id="dateOfBirth">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="nationality">Nationality</label>
                                    <input type="text" class="form-control form-control-user" id="nationality">
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="maritalStatus">Marital Status</label>
                                    <select class="form-control" id="maritalStatus">
                                        <option>Select...</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Divorced</option>
                                        <option>Widowed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#employmentCard" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="employmentCard">
                    <h6 class="m-0 font-weight-bold text-primary">Employment</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="employmentCard" style="">
                    <div class="card-body">
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
@endpush
