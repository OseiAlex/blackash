<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Head, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {
        Head,
        useForm,
        AuthenticatedLayout,
        InputError,
        InputLabel,
        TextInput,
        SelectInput,
        Modal,
        PrimaryButton
    },
    props: {
        errors: Object,
        today_month: String,
        ages: Object,
        products: Object,
        branches: Object
    },
    data() {
        const form = useForm({
            id: null,
            name: null,
            location: null,
            phone: null,
            age_group_id: '',
            product_category_id: '',
            branch_id: '',
            remarks: null
        });

        return {
            form,
            filter: {
                from_date: '',
                to_date: ''
            },
            action: null,
            editContent: false,
            formModal: false,
            viewModal: false,
            destroyModal: false,
            selectedRow: null,
            viewedRow: []
        };
    },
    mounted() {
        this.fetch();

        $(document).on("click", ".edit", (evt) => {
            const data = $(evt.currentTarget).data("id");

            this.showFormModal('edit', data);
        });

        $(document).on("click", ".view", (evt) => {
            const data = $(evt.currentTarget).data("id");

            this.showViewModal('view', data);
        });

        $(document).on("click", ".delete", (evt) => {
            const data = $(evt.currentTarget).data("id");

            this.showDestroyModal('delete', data);
        });

    },
    methods: {
        // staff methods
        fetch() {
            if (
                Date.parse(this.filter.from_date) >
                Date.parse(this.filter.to_date)
            ) {
                toastr.error(
                    "Invalid Date Range!<br>Start date cannot be after End date!"
                );
            } else {
                $("#data_table").DataTable({
                    destroy: true,
                    stateSave: true,
                    processing: false,
                    serverSide: true,
                    ajax: {
                        url: route("records.fetch"),
                        data: {
                            from_date: this.filter.from_date,
                            to_date: this.filter.to_date
                        },
                    },
                    columns: [
                        { data: "recorded_at", name: "recorded_at" },
                        { data: "name", name: "name" },
                        { data: "phone", name: "phone" },
                        { data: "age_group", name: "age_group" },
                        { data: "product_category", name: "product_category" },
                        { data: "branch", name: "branch" },
                        {
                            data: "action",
                            name: "action",
                            orderable: false,
                            searchable: false,
                        },
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        ["10", "25", "50", "100", "All"],
                    ],
                    columnDefs: [
                        { "width": "10%", "targets": 6 }
                    ],
                    order: [["0", "desc"]],
                });
            }
        },
        showFormModal(action, data) {
            this.action = action

            if (action === 'edit') {
                this.editContent = true

                axios
                    .post(route("records.edit"), {
                        id: data,
                    })
                    .then((response) => [
                        Object.assign(this.form, response.data.row),
                    ])
                    .catch((error) => console.log(error));
            }

            this.formModal = true
        },
        hideFormModal() {
            this.formModal = false
            this.editContent = false
            this.action = null
            this.form.reset()
            this.form.clearErrors()
        },
        showViewModal(action, data) {
            this.action = action


            axios
                .post(route("records.show"), {
                    id: data,
                })
                .then((response) => [
                    this.viewedRow = response.data.row,
                    this.viewModal = true
                ])
                .catch((error) => console.log(error));
        },
        hideViewModal() {
            this.viewModal = false
            this.action = null
            this.viewedRow = null
        },
        submit() {
            if (!this.editContent) {
                this.form.post(route("records.store"), {
                    onSuccess: () => {
                        this.hideFormModal();
                        toastr.success("Record successfully saved");
                        this.fetch();
                    },
                    onError: (errors) => {
                        toastr.error("Something went wrong");
                    },
                });
            } else {
                this.form.put(route("records.update", this.form.id), {
                    onSuccess: () => {
                        this.hideFormModal();
                        toastr.success("Record successfully updated");
                        this.fetch();
                    },
                    onError: (errors) => {
                        toastr.error("Something went wrong");
                    },
                });
            }
        },

        showDestroyModal(action, data) {
            this.action = action
            this.selectedRow = data
            this.destroyModal = true
        },
        hideDestroyModal() {
            this.destroyModal = false
            this.selectedRow = null
            this.action = null
        },
        destroy() {
            axios
                .post(route("records.destroy"), {
                    id: this.selectedRow,
                })
                .then((response) => [
                    this.hideDestroyModal(),
                    toastr.success("Item successfully deleted"),
                    this.fetch(),
                ])
                .catch((error) => console.log(error));
        },
        download() {
            axios
                .post(route("records.download"), {
                    from_date: this.filter.from_date,
                    to_date: this.filter.to_date
                })
                .then((response) => [
                    toastr.success('DOwnloaded')
                ])
                .catch((error) => console.log(error));
        }
    },
};
</script>

<template>
    <Head title="Records" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Records
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center gap-1">
                                <span class="text-sm text-gray-700">Show</span>
                                <TextInput v-model="filter.from_date" @change="fetch" type="month" id="from_date"
                                    :max="this.today_month" />
                                <span class="material-symbols-outlined">
                                    trending_flat
                                </span>
                                <TextInput v-model="filter.to_date" @change="fetch" type="month" id="to_date"
                                    :max="this.today_month" />
                                <span class="text-sm text-gray-700">entries</span>
                            </div>

                            <div>
                                <PrimaryButton type="button" class="text-sm" @click="download">
                                    Generate Report
                                </PrimaryButton>
                            </div>
                            <div>
                                <PrimaryButton type="button" class="capitalize text-sm" @click="showFormModal('add')">
                                    Add record
                                </PrimaryButton>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 inline-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-x-auto">
                                        <table id="data_table" class="w-full table-striped">
                                            <thead class="capitalize border-b bg-gray-100 font-medium">
                                                <tr>
                                                    <th scope="col" class="text-sm text-gray-900 px-6 py-4 text-left">
                                                        recorded at
                                                    </th>
                                                    <th scope="col" class="text-sm text-gray-900 px-6 py-4 text-left">
                                                        name
                                                    </th>
                                                    <th scope="col" class="text-sm text-gray-900 px-6 py-4 text-left">
                                                        phone
                                                    </th>
                                                    <th scope="col" class="text-sm text-gray-900 px-6 py-4 text-left">
                                                        Age Group
                                                    </th>
                                                    <th scope="col" class="text-sm text-gray-900 px-6 py-4 text-left">
                                                        product category
                                                    </th>
                                                    <th scope="col" class="text-sm text-gray-900 px-6 py-4 text-left">
                                                        branch
                                                    </th>
                                                    <th scope="col" class="text-sm text-gray-900 px-6 py-4 text-left">
                                                        action
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- form modal -->
        <Modal :show="formModal" :closeable="true" :modalTitle="this.action + ' record'" @close="hideFormModal"
            :maxWidth="'lg'">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-12 gap-5">
                    <div class="col-span-full">
                        <InputLabel for="name" value="Full Name" :required="true" />
                        <TextInput id="name" type="text" class="w-full" v-model="form.name" :placeholder="'Full Name'"
                            autocomplete="name" :class="{ 'border-red-600': form.errors.name }" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <InputLabel for="phone" value="Phone Number" :required="true" />
                        <TextInput id="phone" type="text" class="w-full" v-model="form.phone" :placeholder="'Phone Number'"
                            autocomplete="phone" :class="{ 'border-red-600': form.errors.phone }" />
                        <InputError :message="form.errors.phone" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <InputLabel for="location" value="Location" :required="true" />
                        <TextInput id="location" type="text" class="w-full" v-model="form.location"
                            :placeholder="'Location'" autocomplete="location"
                            :class="{ 'border-red-600': form.errors.location }" />
                        <InputError :message="form.errors.location" class="mt-2" />
                    </div>

                    <div class="col-span-4">
                        <InputLabel for="age_group_id" value="Age Group" :required="true" />
                        <SelectInput class="w-full" id="age_group_id" v-model="form.age_group_id"
                            :class="{ 'border-red-600': form.errors.age_group_id }">
                            <option value="" disabled selected>
                                -- Select Age Group --
                            </option>
                            <option v-for="age in ages" :key="age.id" :value="age.id">
                                {{ age.title }}
                            </option>
                        </SelectInput>
                        <InputError :message="form.errors.age_group_id" class="mt-2" />
                    </div>

                    <div class="col-span-4">
                        <InputLabel for="product_category_id" value="Product Category" :required="true" />
                        <SelectInput class="w-full" id="product_category_id" v-model="form.product_category_id"
                            :class="{ 'border-red-600': form.errors.product_category_id }">
                            <option value="" disabled selected>
                                -- Select Product Category --
                            </option>
                            <option v-for="product in products" :key="product.id" :value="product.id">
                                {{ product.title }}
                            </option>
                        </SelectInput>
                        <InputError :message="form.errors.product_category_id" class="mt-2" />
                    </div>

                    <div class="col-span-4">
                        <InputLabel for="branch_id" value="Branch" :required="true" />
                        <SelectInput class="w-full" id="branch_id" v-model="form.branch_id"
                            :class="{ 'border-red-600': form.errors.branch_id }">
                            <option value="" disabled selected>
                                -- Select Branch --
                            </option>
                            <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                                {{ branch.title }}
                            </option>
                        </SelectInput>
                        <InputError :message="form.errors.branch_id" class="mt-2" />
                    </div>

                    <div class="col-span-full">
                        <InputLabel for="remarks" value="Remarks" :required="true" />
                        <textarea v-model="form.remarks" placeholder="Remarks"
                            :class="{ 'border-red-600': form.errors.remarks }" id="remarks"
                            class="w-full rounded-sm border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-700 focus:outline-none focus:ring-gray-700 sm:text-sm"
                            rows="7"></textarea>
                        <InputError :message="form.errors.remarks" class="mt-2" />
                    </div>

                </div>
                <PrimaryButton type="submit" :disabled="form.processing" :class="{ 'opacity-25': form.processing }"
                    class="mt-4 uppercase tracking-widest text-xs">
                    <div v-if="editContent == false" v-text="'Save'"></div>
                    <div v-else v-text="'Update'"></div>
                </PrimaryButton>
            </form>
        </Modal>
        <!-- end of form modal -->

        <!-- view modal  -->
        <Modal :show="viewModal" :closeable="true" :modalTitle="action + ' record'" @close="hideViewModal" :maxWidth="'md'">
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-full">
                    <InputLabel for="name" value="Full Name" :required="false" />
                    <p class="text-md font-medium">{{ this.viewedRow.name }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="phone" value="Phone" :required="false" />
                    <p class="text-md font-medium">{{ this.viewedRow.phone }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="location" value="Location" :required="false" />
                </div>
                <div class="col-span-full">
                    <p class="text-md font-medium">{{ this.viewedRow.location }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="age" value="Age Group" :required="false" />
                </div>
                <div class="col-span-full">
                    <p class="text-md font-medium">{{ this.viewedRow.age_group.title }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="product" value="Product Category" :required="false" />
                    <p class="text-md font-medium">{{ this.viewedRow.product_category.title }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="branch" value="Branch" :required="false" />
                    <p class="text-md font-medium">{{ this.viewedRow.branch.title }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="remarks" value="Remarks" :required="false" />
                    <p class="text-md font-medium">{{ this.viewedRow.remarks }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="recorded_at" value="Recorded At" :required="false" />
                    <p class="text-md font-medium">{{ this.viewedRow.recorded_at }}</p>
                </div>
                <div class="col-span-full">
                    <InputLabel for="recorded_by" value="Recorded By" :required="false" />
                    <p class="text-md font-medium">{{ this.viewedRow.user.name }}</p>
                </div>
            </div>
        </Modal>
        <!-- end of view modal-->

        <!-- destroy modal  -->
        <Modal :show="destroyModal" :closeable="true" :modalTitle="action + ' record'" @close="hideDestroyModal"
            :maxWidth="'md'">

            <div class="flex justify-center mt-4">
                <p class="text-lg">Are you sure you want to delete this record?</p>
            </div>

            <div class="flex justify-center mt-6 gap-4">
                <PrimaryButton @click="destroy" type="submit" class="mt-4 uppercase text-sm">
                    Yes
                </PrimaryButton>

                <button @click="hideDestroyModal" type="button"
                    class="mt-4 block items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:cursor-not-allowed">
                    Cancel
                </button>
            </div>
        </Modal>
        <!-- end of destroy modal-->
    </AuthenticatedLayout>
</template>

