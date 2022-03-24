<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Employee Management Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="min-w-full align-middle">
                            
                            <form>
                                <div class="m-4">
                                    <BreezeLabel for="code" value="Employee ID" />
                                    <BreezeInput id="code" type="text" class="mt-1 block w-full" v-model="form.code" readonly="readonly" required autofocus autocomplete="username" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="first_name" value="First Name" />
                                    <BreezeInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" readonly="readonly" required autofocus autocomplete="first_name" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="last_name" value="Last Name" />
                                    <BreezeInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" readonly="readonly" required autofocus autocomplete="last_name" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="address" value="Address" />
                                    <BreezeInput id="address" type="text" class="mt-1 block w-full" v-model="form.full_address" readonly="readonly" required autofocus autocomplete="full_address" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="role" value="Role" />
                                    <BreezeInput id="role" type="text" class="mt-1 block w-full" v-model="form.role_name" readonly="readonly" required autofocus autocomplete="role" />
                                </div>

                            </form>

                        </div>                        

                    </div>

                    <div class="m-4">
                        <Link class="float-right inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800" :href="`/employees/${employee.id}/edit`" tabindex="-1">Edit</Link>
                        <Link class="float-right inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800" :href="`/employees/${employee.id}`" method="delete" as="button" tabindex="-1">Delete</Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    export default {
        props: {
            employee: Object,
        },
        data() {
            return {
                form: this.$inertia.form({
                    code: this.employee.code,
                    first_name: this.employee.first_name,
                    last_name: this.employee.last_name,
                    role_name: this.employee.role.name,
                    full_address: this.employee.address.full_address,
                }),
            }
        },
        methods: {
            delete(employee) {
              this.$inertia.delete(this.route('employees.destroy', employee.id), {
                onBefore: () => confirm('Confirmation to delete ' + employee.first_name + ' ' + employee.last_name + '?'),
              })
            },
        }
    }
</script>
