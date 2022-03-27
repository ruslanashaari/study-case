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
                Addresses Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="items-center mb-12">
                            <div class="m-6">
                                <Link class="m-6 float-right inline-flex items-center h-8 px-4 text-sm text-green-100 transition-colors duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800 float-right" :href="this.route('addresses.create')" tabindex="-1" as="button">Create Address</Link>
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
                                <tr v-for="address in addresses">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ address.id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <Link class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" :href="this.route('addresses.show', address.id)">{{ address.full_address }}</Link>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ address.created_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <Link class="inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800" :href="this.route('addresses.edit', address.id)" tabindex="-1">Edit</Link>
                                        <button class="inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800" @click="this.delete(address)">Delete</button>
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
            addresses: Object,
            filters: Object
        },
        data() {
            return {}
        },
        methods: {
            reset() {
              this.form = mapValues(this.form, () => null)
            },
            delete(address) {
              this.$inertia.delete(this.route('addresses.destroy', address.id), {
                onBefore: () => confirm('Confirmation to delete ' + address.full_address + '?'),
              })
            },
        },
    }
</script>
