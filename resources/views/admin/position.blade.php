@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vuetify@4.1.7/dist/vuetify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Positions</h1>

        <a href="{{ route('admin.show_create.position') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fa-solid fa-plus"></i> Add Position</a>
    </div>

    <div id="position-datatable"></div>
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
                const itemsPerPage = ref(8)

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
                const search = ref('')
                const serverItems = ref([])
                const loading = ref(true)
                const totalItems = ref(0)
                const dialog = ref(false)
                const deleting = ref(false)
                const selectedPosition = ref(null)
                const selectedPositionName = ref('')

                async function loadItems({
                    page,
                    itemsPerPage,
                    sortBy,
                    search,
                }) {
                    loading.value = true

                    const params = new URLSearchParams({
                        page,
                        itemsPerPage,
                        search: search ?? '',
                        sortBy: JSON.stringify(sortBy ?? []),
                    })

                    const response = await fetch(
                        `{{ route('admin.datatable.position') }}?${params.toString()}`)
                    const data = await response.json()

                    serverItems.value = data.items
                    totalItems.value = data.total
                    loading.value = false
                }

                function viewEmployee(item) {
                    window.location.href = "{{ route('admin.view.position', ['position_id' => '__ID__']) }}"
                        .replace('__ID__', item.id);
                }

                function editEmployee(item) {
                    window.location.href = "{{ route('admin.edit.position', ['position_id' => '__ID__']) }}"
                        .replace('__ID__', item.id);
                }

                function deleteEmployee(item) {
                    selectedPosition.value = item.id;
                    selectedPositionName.value = item.name || 'this position';
                    dialog.value = true;
                }

                async function confirmDelete() {
                    if (!selectedPosition.value) {
                        return;
                    }

                    deleting.value = true;

                    try {
                        const response = await fetch(
                            `{{ route('admin.delete.position', ['position_id' => '__ID__']) }}`.replace(
                                '__ID__', selectedPosition.value), {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            });

                        if (!response.ok) {
                            throw new Error('Unable to delete position');
                        }

                        dialog.value = false;
                        selectedPosition.value = null;
                        selectedPositionName.value = '';

                        await loadItems({
                            page: 1,
                            itemsPerPage: itemsPerPage.value,
                            sortBy: [],
                            search: search.value,
                        });
                    } catch (error) {
                        console.error(error);
                        alert('Unable to delete the position.');
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
                    viewEmployee,
                    editEmployee,
                    deleteEmployee,
                    confirmDelete,
                    dialog,
                    deleting,
                    selectedPosition,
                    selectedPositionName,
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
                    loading-text="Loading positions... Please wait"
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
                                <v-btn v-bind="props" class="mr-1" color="success" title="View" size="small" @click="viewEmployee(item)">
                                    <i class="fa-regular fa-eye"></i>
                                </v-btn>
                            </template>
                        </v-tooltip>

                        <v-tooltip location="top" color="primary" text="Edit">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" class="mr-1" color="primary" title="Edit" size="small" @click="editEmployee(item)">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </v-btn>
                            </template>
                        </v-tooltip>

                        <v-tooltip location="top" color="danger" text="Delete">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" class="mr-1" color="danger" title="View" size="small" @click="deleteEmployee(item)">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </v-btn>
                            </template>
                        </v-tooltip>
                    </div>
                </template>
                
                </v-data-table-server>

            <div class="text-center pa-4">
                <v-dialog v-model="dialog" max-width="400">
                    <v-card>
                        <v-card-title>Delete position</v-card-title>
                        <v-card-text>
                            Are you sure you want to delete
                            <strong>@{{ selectedPositionName }}</strong>?
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
        app.mount('#position-datatable')
    </script>
@endpush
