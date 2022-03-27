<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Employee Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="items-center mb-12">
                            <div class="m-6">
                                <label class="ml-4">Filter Address:</label>
                                <select class="mt-1 ml-4 rounded-lg">
                                    <option v-for="address in addresses" :value="address.id">{{ address.full_address }}</option>
                                </select>
                                <label class="ml-4">Filter Records:</label>
                                <select class="mt-1 ml-4 rounded-lg" @change="filterTrashedList($event)">
                                    <option value="active"> Don't Show Deleted Records </option>
                                    <option value="both"> Show With Deleted Records </option>
                                    <option value="deleted"> Show Deleted Records Only </option>
                                </select>
                                <Link class="float-right inline-flex items-center h-8 px-4 m-2 text-sm text-green-100 transition-colors duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800 float-right" :href="this.route('employees.create')" tabindex="-1" as="button">Create Employee</Link>
                            </div>       
                        </div>

                        <div class="min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Employee Code</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">First Name</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Last Name</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Address</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Created At</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                <tr v-for="employee in list">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ employee.id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <Link class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" :href="this.route('employees.show', employee.id)">{{ employee.code }}</Link>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ employee.first_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ employee.last_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ employee.address.full_address }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ employee.created_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <Link class="inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800" :href="this.route('employees.edit', employee.id)" tabindex="-1">Edit</Link>
                                        <button class="inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800" @click="this.delete(employee)">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>                        

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    export default {
        props: {
            employees: Object,
            addresses: Object,
            filters: Object
        },
        data() {
            return {
                list: []
            }
        },
        mounted() {
            this.list = this.employees
        },
        methods: {
            reset() {
              this.form = mapValues(this.form, () => null)
            },
            delete(employee) {
              this.$inertia.delete(this.route('employees.destroy', employee.id), {
                onBefore: () => confirm('Confirmation to delete ' + employee.first_name + ' ' + employee.last_name + '?'),
                onSuccess: (success) => {
                    this.filterList()
                }
              })
            },
            filterTrashedList(event) {
                var option = event.target.value 

                this.filterList(option, '')
            },
            filterList(trashed = '', search = '') {
                var filters = {
                    'trashed': trashed,
                    'search': search
                }

                window.axios
                .post(route('api.employees.list'), filters)
                .then((response) => {

                    if (response.data.status == 200) {
                        this.list = response.data.data
                    }

                })
                .catch((errors) => {
                  console.log(JSON.stringify(errors, null, 2))
                });
            }
        },
    }
</script>
