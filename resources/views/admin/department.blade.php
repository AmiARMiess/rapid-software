@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vuetify@4.1.7/dist/vuetify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Departments</h1>

        <a href="{{ route('admin.create.department') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fa-solid fa-plus"></i> Add Department</a>
    </div>

    <div id="department-datatable">
        <template>
            <v-data-table-server v-model:items-per-page="itemsPerPage" :headers="headers" :items="serverItems"
                :items-length="totalItems" :loading="loading" @update:options="loadItems"></v-data-table-server>
        </template>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.5.39/vue.global.prod.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@4.1.7/dist/vuetify.min.js"></script>



    <script>
        const {
            ref,
            createApp
        } = Vue

        const app = createApp({
            setup() {


                const headers = ref([{
                        title: 'Name',
                        key: 'name',
                    },
                    {
                        title: 'Actions',
                        key: 'actions',
                        sortable: false,
                        align: 'center',
                    },
                ])
                const itemsPerPage = ref(8)
                const search = ref('')
                const serverItems = ref([])
                const loading = ref(true)
                const totalItems = ref(0)
                const dialog = ref(false)
                const deleting = ref(false)
                const selectedDepartment = ref(null)
                const selectedDepartmentName = ref('')
                const snackbarMessage = ref(@json(session('success')) || '');
                const showSnackbar = ref(!!snackbarMessage.value);

                async function loadItems({
                    page,
                    itemsPerPage,
                    sortBy,
                    search
                }) {
                    loading.value = true

                    const params = new URLSearchParams({
                        page,
                        itemsPerPage,
                        search: search ?? '',
                        sortBy: JSON.stringify(sortBy ?? []),
                    })

                    const response = await fetch(
                        `{{ route('admin.datatable.department') }}?${params.toString()}`)
                    const data = await response.json()

                    serverItems.value = data.items
                    totalItems.value = data.total
                    loading.value = false
                }

                function viewDepartment(item) {
                    console.log(item.id);
                    window.location.href = "{{ route('admin.view.department', ['department_id' => '__ID__']) }}"
                        .replace('__ID__', item.id);
                }

                function editDepartment(item) {
                    window.location.href = "{{ route('admin.edit.department', ['department_id' => '__ID__']) }}"
                        .replace('__ID__', item.id);
                }

                function deleteDepartment(item) {
                    selectedDepartment.value = item.id;
                    selectedDepartmentName.value = item.name || 'this department';
                    dialog.value = true;
                }

                async function confirmDelete() {
                    if (!selectedDepartment.value) {
                        return;
                    }

                    deleting.value = true;

                    try {
                        const response = await fetch(
                            `{{ route('admin.delete.position', ['department_id' => '__ID__']) }}`.replace(
                                '__ID__', selectedDepartment.value), {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            });

                        if (!response.ok) {
                            throw new Error('Unable to delete department');
                        }

                        dialog.value = false;
                        selectedDepartment.value = null;
                        selectedDepartmentName.value = '';
                        snackbarMessage.value = 'Department deleted successfully.';
                        showSnackbar.value = true;

                        await loadItems({
                            page: 1,
                            itemsPerPage: itemsPerPage.value,
                            sortBy: [],
                            search: search.value,
                        });
                    } catch (error) {
                        console.error(error);
                        alert('Unable to delete the department.');
                    } finally {
                        deleting.value = false;
                    }
                }

                return {
                    itemsPerPage,
                    headers,
                    search,
                    serverItems,
                    loading,
                    totalItems,
                    loadItems,
                    viewDepartment,
                    editDepartment,
                    deleteDepartment,
                    confirmDelete,
                    dialog,
                    deleting,
                    selectedDepartment,
                    selectedDepartmentName,
                    showSnackbar,
                    snackbarMessage
                }
            },
            template: `
            <v-text-field v-model="search" density="compact" label="Search.." class="col-4 float-right pb-2" prepend-inner-icon="mdi-magnify"
                    variant="solo-filled" flat hide-details single-line></v-text-field>

            <v-divider></v-divider>

                <v-data-table-server
                    v-model:items-per-page="itemsPerPage"
                    :headers="headers"
                    :items="serverItems"
                    :items-length="totalItems"
                    loading-text="Loading departments... Please wait"
                    :loading="loading"
                    :search="search"
                    class="table-striped"
                    item-value="name"
                    @update:options="loadItems"
                >
                <template v-slot:header.name>
                    <div class="font-weight-bold">Name</div>
                </template>
                <template v-slot:header.actions>
                    <div class="font-weight-bold">Actions</div>
                </template>
                <template v-slot:item.actions="{ item }">
                    <div class="d-flex gap-2">
                        <v-tooltip location="top" color="success" text="View">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" class="mr-1" color="success" title="View" size="small" @click="viewDepartment(item)">
                                    <i class="fa-regular fa-eye"></i>
                                </v-btn>
                            </template>
                        </v-tooltip>

                        <v-tooltip location="top" color="primary" text="Edit">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" class="mr-1" color="primary" title="Edit" size="small" @click="editDepartment(item)">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </v-btn>
                            </template>
                        </v-tooltip>

                        <v-tooltip location="top" color="danger" text="Delete">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" class="mr-1" color="danger" title="View" size="small" @click="deleteDepartment(item)">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </v-btn>
                            </template>
                        </v-tooltip>
                    </div>
                </template>
                
                </v-data-table-server>

                <v-snackbar v-model="showSnackbar" color="success" location="bottom end" timeout="3000" title="Success"
                    prepend-icon="$success">
                    @{{ snackbarMessage }}
                </v-snackbar>

                <div class="text-center pa-4">
                    <v-dialog v-model="dialog" max-width="400">
                        <v-card>
                            <v-card-title>Delete department</v-card-title>
                            <v-card-text>
                                Are you sure you want to delete
                                <strong>@{{ selectedDepartmentName }}</strong>?
                            </v-card-text>
                            <template #actions>
                                <v-spacer></v-spacer>
                                <v-btn text color="secondary" @click="dialog = false" :disabled="deleting">
                                    Cancel
                                </v-btn>
                                <v-btn color="danger" @click="confirmDelete" :loading="deleting" :disabled="deleting">
                                    Delete
                                </v-btn>
                            </template>
                        </v-card>
                    </v-dialog>
                </div>
            `,
        })

        app.use(Vuetify.createVuetify())
        app.mount('#department-datatable')
    </script>
@endpush
