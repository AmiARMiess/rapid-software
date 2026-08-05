@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vuetify@4.1.7/dist/vuetify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
@endpush

@section('content')
    <div id="department-edit-form">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Edit Department</h1>
                <div class="text-muted">Update the department profile and its ownership responsibilities</div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.departments') }}" class="btn btn-light btn-sm shadow-sm mr-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <button class="btn btn-success btn-sm shadow-sm" type="button" id="department-save-button">
                    <i class="fa-solid fa-floppy-disk"></i> Save Department
                </button>
            </div>
        </div>

        <form id="department-form" method="POST"
            action="{{ route('admin.update.department', ['department_id' => $department->id]) }}">
            @csrf

            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Department Name *</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <input type="text" class="form-control" name="name" id="departmentName"
                                            v-model="departmentName"
                                            :class="{ 'is-invalid': v$.departmentName.$dirty && v$.departmentName.$invalid }"
                                            @input="setDepartmentName"
                                            placeholder="e.g. Engineering">
                                        <div v-if="v$.departmentName.$dirty && v$.departmentName.$invalid"
                                            class="invalid-feedback d-block">
                                            <div v-if="v$.departmentName.required.$invalid">Department name is required</div>
                                            <div v-if="v$.departmentName.minLength.$invalid">Department name must have at least 3 characters</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-building fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Team Count</div>
                                    {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $department->positions()->count() ?? 0 }}</div> --}}
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">X</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-users fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Status</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Active</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-circle-check fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Department Details</h6>
                        <span class="badge badge-info">Draft</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Description</label>
                                <textarea class="form-control" rows="4" name="description" placeholder="Describe the department purpose, objectives, and scope">{{ old('description', $department->description ?? '') }}</textarea>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Department Responsibilities</label>
                                <div id="responsibility-list" class="d-flex flex-column gap-2 mb-3">
                                    @forelse (collect(old('responsibilities', []))->filter(fn($responsibility) => filled($responsibility)) as $responsibility)
                                        <div class="input-group responsibility-item pb-2">
                                            <input type="text" class="form-control" name="responsibilities[]" value="{{ $responsibility }}" placeholder="Add a department responsibility">
                                            <button type="button" class="btn btn-outline-danger remove-responsibility" title="Remove">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    @empty
                                        <div class="input-group responsibility-item pb-2">
                                            <input type="text" class="form-control" name="responsibilities[]" placeholder="Add a department responsibility">
                                            <button type="button" class="btn btn-outline-danger remove-responsibility" title="Remove">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    @endforelse
                                </div>

                                <button type="button" id="add-responsibility" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-plus"></i> Add Input
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.5.39/vue.global.prod.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@4.1.7/dist/vuetify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-demi"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vuelidate/core"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vuelidate/validators"></script>

    <script>
        const { createApp, ref } = window.Vue;
        const { createVuetify } = window.Vuetify;
        const { useVuelidate } = window.Vuelidate;
        const { required, minLength } = window.VuelidateValidators;

        const departmentApp = createApp({
            setup() {
                const departmentName = ref(@json(old('name', $department->name)) || '');

                const v$ = useVuelidate({
                    departmentName: {
                        required,
                        minLength: minLength(3),
                    }
                }, {
                    departmentName,
                });

                const setDepartmentName = ($event) => {
                    departmentName.value = $event.target.value.trim();
                    v$.value.departmentName.$touch();
                };

                const validateAndSubmit = () => {
                    v$.value.$touch();

                    if (v$.value.$invalid) {
                        return false;
                    }

                    document.getElementById('department-form').requestSubmit();
                    return true;
                };

                window.departmentController = { validateAndSubmit };

                return {
                    departmentName,
                    v$,
                    setDepartmentName,
                };
            }
        });

        const vuetify = createVuetify();
        departmentApp.use(vuetify).mount('#department-edit-form');

        document.addEventListener('DOMContentLoaded', function() {
            const saveButton = document.getElementById('department-save-button');
            if (saveButton) {
                saveButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (window.departmentController && window.departmentController.validateAndSubmit) {
                        window.departmentController.validateAndSubmit();
                    }
                });
            }

            const list = document.getElementById('responsibility-list');
            const addButton = document.getElementById('add-responsibility');

            const createResponsibilityField = () => {
                const wrapper = document.createElement('div');
                wrapper.className = 'input-group responsibility-item py-2';
                wrapper.innerHTML = `
                    <input type="text" class="form-control" name="responsibilities[]" placeholder="Add a department responsibility">
                    <button type="button" class="btn btn-outline-danger remove-responsibility" title="Remove">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;
                return wrapper;
            };

            if (addButton) {
                addButton.addEventListener('click', function() {
                    if (list) {
                        list.appendChild(createResponsibilityField());
                    }
                });
            }

            if (list) {
                list.addEventListener('click', function(event) {
                    if (event.target.closest('.remove-responsibility')) {
                        const item = event.target.closest('.responsibility-item');
                        if (list.querySelectorAll('.responsibility-item').length > 1 && item) {
                            item.remove();
                        }
                    }
                });
            }
        });
    </script>
@endpush
