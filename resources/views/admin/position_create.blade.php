@extends('layouts.app')

@section('content')
    <div id="position-create-form">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Create Position</h1>
                <div class="text-muted">Add a new position profile based on the current position view structure</div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.positions') }}" class="btn btn-light btn-sm shadow-sm mr-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <button class="btn btn-success btn-sm shadow-sm" type="submit" form="position-form" @click.prevent="submitPositionForm">
                    <i class="fa-solid fa-floppy-disk"></i> Save Position
                </button>
            </div>
        </div>

        <form id="position-form" method="POST" action="{{ route('admin.create.position') }}">
            @csrf
            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Position</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <input type="text" class="form-control" name="name" :value="positionName"
                                            @input="setPositionName"
                                            :class="{ 'is-invalid': v$.positionName.$dirty && v$.positionName.$invalid }"
                                            id="positionName" placeholder="e.g. Senior Developer">

                                        <div v-if="v$.positionName.$dirty && v$.positionName.$invalid"
                                            class="invalid-feedback d-block">
                                            <div v-if="v$.positionName.required.$invalid">Position is required</div>
                                        </div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-users fa-2x text-success"></i>
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
                                        <select name="status" class="form-control">
                                            @foreach ($optionStatuses as $optionStatus)
                                                <option value="{{ $optionStatus->id }}">{{ $optionStatus->name }}</option>
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

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Level</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <select name="level" class="form-control">
                                            @foreach ($optionLevels as $optionLevel)
                                                <option value="{{ $optionLevel->id }}">{{ $optionLevel->name }}</option>
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
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Reporting
                                    To</label>
                                <select class="form-control" name="reporting_to">
                                    <option value="">Select reporting position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label
                                    class="text-xs font-weight-bold text-uppercase text-gray-500 mb-1">Description</label>
                                <textarea class="form-control" rows="4" name="description" placeholder="Describe the role, mandate, and scope"></textarea>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div id="responsibility-list" class="d-flex flex-column gap-2 mb-3">
                                    <div class="input-group responsibility-item pb-2">
                                        <input type="text" class="form-control" name="responsibilities[]"
                                            placeholder="Add key accountability or responsibility">
                                        <button type="button" class="btn btn-outline-danger remove-responsibility"
                                            title="Remove">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            addButton.addEventListener('click', function() {
                list.appendChild(createResponsibilityField());
            });

            list.addEventListener('click', function(event) {
                if (event.target.closest('.remove-responsibility')) {
                    const item = event.target.closest('.responsibility-item');
                    if (list.querySelectorAll('.responsibility-item').length > 1) {
                        item.remove();
                    }
                }
            });
        });
    </script>

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
        } = window.VuelidateValidators;

        createApp({
            setup() {
                const positionName = ref('');

                const v$ = useVuelidate({
                    positionName: {
                        required,
                    },
                }, {
                    positionName,
                });

                const setPositionName = ($event) => {
                    positionName.value = $event.target.value.trim();
                    v$.value.positionName.$touch();
                };

                const submitPositionForm = () => {
                    v$.value.positionName.$touch();

                    if (v$.value.positionName.$invalid) {
                        return;
                    }

                    document.getElementById('position-form').requestSubmit();
                };

                return {
                    positionName,
                    v$,
                    setPositionName,
                    submitPositionForm,
                };
            }
        }).mount('#position-create-form');
    </script>
@endpush
