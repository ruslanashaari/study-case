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
                Address Management Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="min-w-full align-middle">
                            
                            <form @submit.prevent="update">
                                <div class="m-4">
                                    <BreezeLabel for="address_1" value="Address Line 1" />
                                    <BreezeInput id="address_1" type="text" class="mt-1 block w-full" v-model="form.address_1" required autofocus readonly="readonly" autocomplete="address_1" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="address_2" value="Address Line 2" />
                                    <BreezeInput id="address_2" type="text" class="mt-1 block w-full" v-model="form.address_2" autofocus readonly="readonly" autocomplete="address_2" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="district" value="District" />
                                    <BreezeInput id="district" type="text" class="mt-1 block w-full" v-model="form.district" required autofocus readonly="readonly" autocomplete="district" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="postcode" value="Postcode" />
                                    <BreezeInput id="postcode" type="text" class="mt-1 block w-full" v-model="form.postcode" autofocus readonly="readonly" autocomplete="postcode" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="city" value="City" />
                                    <BreezeInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" required autofocus readonly="readonly" autocomplete="city" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="country" value="Country" />
                                    <BreezeInput id="country" type="text" class="mt-1 block w-full" v-model="form.country" required autofocus readonly="readonly" autocomplete="country" />
                                </div>
                            </form>

                        </div>                        

                    </div>

                    <div class="m-4">
                        <Link class="float-right inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800" :href="this.route('addresses.edit', address.id)" tabindex="-1">Edit</Link>
                        <Link class="float-right inline-flex items-center h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800" @click="this.delete(address)" tabindex="-1">Delete</Link>
                    </div>

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    export default {
        props: {
            address: Object,
            country: String,
        },
        data() {
            return {
                form: this.$inertia.form({
                    address_1: this.address.address_1,
                    address_2: this.address.address_2,
                    district: this.address.district,
                    postcode: this.address.postcode,
                    city: this.address.city,
                    country: this.country,
                }),
            }
        },
        methods: {
            delete(address) {
              this.$inertia.delete(this.route('addresses.destroy', address.id), {
                onBefore: () => confirm('Confirmation to delete ' + address.full_address + '?'),
              })
            },
        }
    }
</script>
