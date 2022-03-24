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
                            
                            <form @submit.prevent="update">
                                <div class="m-4">
                                    <BreezeLabel for="code" value="Employee ID" />
                                    <BreezeInput id="code" type="text" class="mt-1 block w-full" v-model="form.code" required autofocus autocomplete="username" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="first_name" value="First Name" />
                                    <BreezeInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required autofocus autocomplete="first_name" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="last_name" value="Last Name" />
                                    <BreezeInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required autofocus autocomplete="last_name" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="address" value="Address" />
                                    <select v-model="form.address_id" class="mt-1 block w-full rounded-lg" required autofocus autocomplete="address" >
                                        <option v-for="address in addresses" :value="address.id">{{ address.full_address }}</option>
                                    </select>
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="role" value="Role" />
                                    <select v-model="form.employee_role_id" class="mt-1 block w-full rounded-lg" required autofocus autocomplete="role" >
                                        <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                                    </select>
                                </div>

                                <div class="flex items-center justify-end m-4">
                                    <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Update
                                    </BreezeButton>
                                </div>
                            </form>

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
            employee: Object,
            addresses: Object,
            roles: Object,
        },
        data() {
            return {
                form: this.$inertia.form({
                    code: this.employee.code,
                    first_name: this.employee.first_name,
                    last_name: this.employee.last_name,
                    address_id: this.employee.address_id,
                    employee_role_id: this.employee.employee_role_id,
                }),
            }
        },
        methods: {
            update() {
              this.form.put(`/employees/${this.employee.id}`);
            },
        },
    }
</script>
