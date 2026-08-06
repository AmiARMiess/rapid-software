@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vuetify@4.1.7/dist/vuetify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
@endpush

@section('content')
    <div id="position-edit-form">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Edit Position</h1>
                <div class="text-muted">Edit a position profile based on the current position view structure</div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.positions') }}" class="btn btn-light btn-sm shadow-sm mr-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <button class="btn btn-success btn-sm shadow-sm" type="button" id="position-save-button">
                    <i class="fa-solid fa-floppy-disk"></i> Save Position
                </button>
            </div>
        </div>

        <form id="position-form" method="POST"
            action="{{ route('admin.update.position', ['position_id' => $position->id]) }}">
            @csrf


            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Position *</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <input type="text" class="form-control" name="name" id="positionName"
                                            v-model="positionName"
                                            :class="{ 'is-invalid': v$.positionName.$dirty && v$.positionName.$invalid }"
                                            @input="setPositionName"
                                            placeholder="e.g. Senior Developer">
                                        <div v-if="v$.positionName.$dirty && v$.positionName.$invalid"
                                            class="invalid-feedback d-block">
                                            <div v-if="v$.positionName.required.$invalid">Position is required</div>
                                            <div v-if="v$.positionName.minLength.$invalid">Position must have at least 4 characters</div>
                                        </div>

                                        <v-snackbar
                                            v-model="showSnackbar"
                                            color="success"
                                            location="bottom end"
                                            timeout="3000"
                                            title="Success"
                                            prepend-icon="$success"
                                        >
                                            @{{ snackbarMessage }}
                                        </v-snackbar>
                                    </div>
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
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Employees</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countTotalPosition }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-users fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Level</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <select class="form-control" name="level">
                                            @foreach ($optionLevels as $optionLevel)
                                                <option value="{{ $optionLevel->id }}"
                                                    {{ $optionLevel->id == ($position->level ?? null) ? 'selected' : '' }}>
                                                    {{ $optionLevel->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-ranking-star fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Status</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <select class="form-control" name="status">
                                            @foreach ($optionStatuses as $optionStatus)
                                                <option value="{{ $optionStatus->id }}"
                                                    {{ $optionStatus->id == ($position->status ?? null) ? 'selected' : '' }}>
                                                    {{ $optionStatus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                        <h6 class="m-0 font-weight-bold text-primary">Position Details</h6>
                        <span class="badge badge-info">Draft</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Department</label>
                                <select class="form-control" name="department">
                                    <option value="">Select department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $department->id == ($position->department ?? null) ? 'selected' : '' }}>
                                            {{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Reporting
                                    To</label>
                                <select class="form-control" name="reporting_to">
                                    <option value="">Select reporting position</option>
                                    @foreach ($positions as $position_list)
                                        <option value="{{ $position_list->id }}"
                                            {{ $position_list->id == ($position->reporting_to ?? null) ? 'selected' : '' }}>
                                            {{ $position_list->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label
                                    class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Description</label>
                                <textarea class="form-control" rows="4" name="description" placeholder="Describe the role, mandate, and scope">{{ $position->description }}</textarea>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div id="responsibility-list" class="d-flex flex-column gap-2 mb-3">
                                    @forelse ($position->positionResponsibles as $responsible)
                                        <div class="input-group responsibility-item pb-2">
                                            <input type="text" class="form-control" name="responsibilities[]"
                                                value="{{ old('responsibilities.' . $loop->index, $responsible->name) }}"
                                                placeholder="Add key accountability or responsibility">
                                            <button type="button" class="btn btn-outline-danger remove-responsibility"
                                                title="Remove">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    @empty
                                        <div class="input-group responsibility-item pb-2">
                                            <input type="text" class="form-control" name="responsibilities[]"
                                                placeholder="Add key accountability or responsibility">
                                            <button type="button" class="btn btn-outline-danger remove-responsibility"
                                                title="Remove">
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

        const positionApp = createApp({
            setup() {
                const positionName = ref(@json(old('name', $position->name)) || '');
                const snackbarMessage = ref(@json(session('success')) || '');
                const showSnackbar = ref(!!snackbarMessage.value);

                const v$ = useVuelidate({
                    positionName: {
                        required,
                        minLength: minLength(4),
                    }
                }, {
                    positionName,
                });

                const setPositionName = ($event) => {
                    positionName.value = $event.target.value.trim();
                    v$.value.positionName.$touch();
                };

                const validateAndSubmit = () => {
                    v$.value.$touch();

                    if (v$.value.$invalid) {
                        return false;
                    }

                    document.getElementById('position-form').requestSubmit();
                    return true;
                };

                window.positionController = { validateAndSubmit };

                return {
                    positionName,
                    v$,
                    setPositionName,
                    showSnackbar,
                    snackbarMessage
                };
            }
        });

        const vuetify = createVuetify();
        positionApp.use(vuetify).mount('#position-edit-form');

        // Hook Save button to validation
        document.addEventListener('DOMContentLoaded', function() {
            const saveButton = document.getElementById('position-save-button');
            if (saveButton) {
                saveButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (window.positionController && window.positionController.validateAndSubmit) {
                        window.positionController.validateAndSubmit();
                    }
                });
            }

            // Responsibility list functionality
            const list = document.getElementById('responsibility-list');
            const addButton = document.getElementById('add-responsibility');

            const createResponsibilityField = () => {
                const wrapper = document.createElement('div');
                wrapper.className = 'input-group responsibility-item py-2';
                wrapper.innerHTML = `
                    <input type="text" class="form-control" name="responsibilities[]" placeholder="Add key accountability or responsibility">
                    <button type="button" class="btn btn-outline-danger remove-responsibility" title="Remove">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;
                return wrapper;
            };

            if (addButton) {
                addButton.addEventListener('click', function() {
                    if (list) list.appendChild(createResponsibilityField());
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
