@extends('layouts.app')

@push('head')
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Claims</h1>
    </div>
    <div class="pb-3">Record a new claim</div>


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
                const maritalStatus = ref('');
                const childrenEligibleForTaxRelief = ref('');
                const employeeEfpRateUseComapnyDefault = ref(true);

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
                    maritalStatus: {
                        required,
                    },
                    salary: {
                        required,
                        numeric
                    },
                    dateOfBirth: {
                        required,
                    },
                    childrenEligibleForTaxRelief: {
                        numeric,
                    },
                }, {
                    fullName,
                    gender,
                    position,
                    maritalStatus,
                    salary,
                    dateOfBirth,
                    childrenEligibleForTaxRelief
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

                const setChildrenEligibleForTaxRelief = ($event) => {
                    childrenEligibleForTaxRelief.value = $event.target.value;
                    v$.value.childrenEligibleForTaxRelief.$touch();
                };

                const setMaritalStatus = ($event) => {
                    maritalStatus.value = $event.target.value;
                    v$.value.maritalStatus.$touch();
                };

                const setEmployeeEfpRateUseComapnyDefault = ($event) => {
                    employeeEfpRateUseComapnyDefault.value = $event.target.checked;
                };


                return {
                    fullName,
                    gender,
                    position,
                    salary,
                    dateOfBirth,
                    maritalStatus,
                    childrenEligibleForTaxRelief,
                    employeeEfpRateUseComapnyDefault,
                    v$,
                    setFullName,
                    setGender,
                    setPosition,
                    setSalary,
                    setDateOfBirth,
                    setChildrenEligibleForTaxRelief,
                    setMaritalStatus,
                    setEmployeeEfpRateUseComapnyDefault
                };
            }
        }).mount('#employee-form');
    </script>
@endpush
