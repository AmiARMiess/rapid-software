@extends('layouts.app')

@push('head')
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="pb-3">Record a new employee</div>

    <div id="employee-form">
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
                                <label v-bind:class="{ 'text-danger': v$.fullName.$dirty && v$.fullName.$invalid }"
                                    for="fullName">Full Name *</label>
                                <input type="text" :value="fullName" @input="setFullName"
                                    class="form-control form-control-user"
                                    :class="{ 'is-invalid': v$.fullName.$dirty && v$.fullName.$invalid }" id="fullName"
                                    placeholder="">

                                <div v-if="v$.fullName.$dirty && v$.fullName.$invalid" class="invalid-feedback d-block">
                                    <div v-if="v$.fullName.required.$invalid">Name is required</div>
                                    <div v-if="v$.fullName.alpha.$invalid">Name must contain only letters</div>
                                    <div v-if="v$.fullName.minLength.$invalid">Name must have at least 4 letters</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="icNumber">IC Number</label>
                                    <input type="text" class="form-control form-control-user" id="icNumber"
                                        placeholder="890211-14-1234">
                                </div>
                                <div class="form-group col-6">
                                    <label v-bind:class="{ 'text-danger': v$.gender.$dirty && v$.gender.$invalid }"
                                        for="gender">Gender *</label>
                                    <select :value="gender" @input="setGender" class="form-control form-control-user"
                                        :class="{ 'is-invalid': v$.gender.$dirty && v$.gender.$invalid }" id="gender">
                                        <option value="" selected>Select...</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>

                                    <div v-if="v$.gender.$dirty && v$.gender.$invalid" class="invalid-feedback d-block">
                                        <div v-if="v$.gender.required.$invalid">Gender is required</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="religion">Religion</label>
                                    <select class="form-control form-control-user" id="religion">
                                        <option>Select...</option>
                                        <option>Islam</option>
                                        <option>Hindu</option>
                                        <option>Buddhist</option>
                                        <option>Christian</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label
                                        v-bind:class="{ 'text-danger': v$.dateOfBirth.$dirty && v$.dateOfBirth.$invalid }"
                                        for="dateOfBirth">Date of Birth *</label>
                                    <input type="date" :value="dateOfBirth" @input="setDateOfBirth"
                                        :class="{ 'is-invalid': v$.dateOfBirth.$dirty && v$.dateOfBirth.$invalid }"
                                        class="form-control form-control-user" id="dateOfBirth">

                                    <div v-if="v$.dateOfBirth.$dirty && v$.dateOfBirth.$invalid"
                                        class="invalid-feedback d-block">
                                        <div v-if="v$.dateOfBirth.required.$invalid">Date of Birth is required</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="nationality">Nationality</label>
                                    <input type="text" class="form-control form-control-user" id="nationality">
                                </div>
                                <div class="form-group col-6">
                                    <label for="maritalStatus">Marital Status</label>
                                    <select class="form-control form-control-user" id="maritalStatus">
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

                            <div class="form-group col-12">
                                <label for="employeeNumber">Employee Number</label>
                                <input type="text" class="form-control form-control-user" id="employeeNumber" readonly>
                            </div>

                            <div class="form-group col-12">
                                <label v-bind:class="{ 'text-danger': v$.position.$dirty && v$.position.$invalid }"
                                    for="position">Position</label>
                                <select :value="position" @input="setPosition"
                                    v-bind:class="{ 'is-invalid': v$.position.$dirty && v$.position.$invalid }"
                                    class="form-control form-control-user" id="position">
                                    <option value="">Select...</option>
                                    <option value="xx">fdsfds</option>
                                </select>

                                <div v-if="v$.position.$dirty && v$.position.$invalid" class="invalid-feedback d-block">
                                    <div v-if="v$.position.required.$invalid">Position is required</div>
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <label for="department">Department</label><span class="float-right">+ Add
                                    department</span>
                                <select class="form-control form-control-user" id="department">
                                    <option value="">Select...</option>
                                    <option value="xx">fdsfds</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="hireDate">Hire Date</label>
                                <input type="date" class="form-control form-control-user" id="hireDate">
                            </div>

                            <div class="form-group col-12">
                                <label for="confirmationDate">Confirmation Date</label>
                                <input type="date" class="form-control form-control-user" id="confirmationDate">
                            </div>

                            <div class="form-group col-12">
                                <label for="employmentType">Employment Type</label>
                                <select class="form-control form-control-user" id="employmentType">
                                    <option>Select...</option>
                                    <option>Permanent</option>
                                    <option>Work form home</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label :class="{ 'text-danger': v$.salary.$dirty && v$.salary.$invalid }"
                                    for="salary">Salary</label>
                                <input :value="salary" @input="setSalary"
                                    :class="{ 'is-invalid': v$.salary.$dirty && v$.salary.$invalid }" type="text"
                                    inputmode="numeric" class="form-control form-control-user" id="salary">

                                <div v-if="v$.salary.$dirty && v$.salary.$invalid" class="invalid-feedback d-block">
                                    <div v-if="v$.salary.required.$invalid">Salary is required</div>
                                    <div v-if="v$.salary.numeric.$invalid">Salary must be number</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
    <!--  Vuelidate -->
    <script src="https://cdn.jsdelivr.net/npm/vue-demi"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vuelidate/core"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vuelidate/validators"></script>

    <script>
        const {
            createApp,
            ref
        } = window.Vue;
        const {
            useVuelidate
        } = window.Vuelidate;
        const {
            required,
            email,
            alpha,
            minLength,
            numeric,
            between
        } = window.VuelidateValidators;

        createApp({
            setup() {
                const fullName = ref('');
                const gender = ref('');
                const position = ref('');
                const salary = ref('');
                const dateOfBirth = ref('');

                const v$ = useVuelidate({
                    fullName: {
                        required,
                        alpha,
                        minLength: minLength(4)
                    },
                    gender: {
                        required,
                    },
                    position: {
                        required,
                    },
                    salary: {
                        required,
                        numeric
                    },
                    dateOfBirth: {
                        required,
                    },
                }, {
                    fullName,
                    gender,
                    position,
                    salary,
                    dateOfBirth
                });

                const setFullName = ($event) => {
                    fullName.value = $event.target.value.trim();
                    v$.value.fullName.$touch();
                };

                const setGender = ($event) => {
                    gender.value = $event.target.value;
                    v$.value.gender.$touch();
                };

                const setPosition = ($event) => {
                    position.value = $event.target.value;
                    v$.value.position.$touch();
                };

                const setSalary = ($event) => {
                    salary.value = $event.target.value;
                    v$.value.salary.$touch();
                };

                const setDateOfBirth = ($event) => {
                    dateOfBirth.value = $event.target.value;
                    v$.value.dateOfBirth.$touch();
                };

                return {
                    fullName,
                    gender,
                    position,
                    salary,
                    dateOfBirth,
                    v$,
                    setFullName,
                    setGender,
                    setPosition,
                    setSalary,
                    setDateOfBirth
                };
            }
        }).mount('#employee-form');
    </script>
@endpush
