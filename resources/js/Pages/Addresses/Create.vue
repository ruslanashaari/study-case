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
                            
                            <form @submit.prevent="store">
                                <div class="m-4">
                                    <BreezeLabel for="address_1" value="Address Line 1" />
                                    <BreezeInput id="address_1" type="text" class="mt-1 block w-full" v-model="form.address_1" required autofocus autocomplete="address_1" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="address_2" value="Address Line 2" />
                                    <BreezeInput id="address_2" type="text" class="mt-1 block w-full" v-model="form.address_2" autofocus autocomplete="address_2" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="district" value="District" />
                                    <BreezeInput id="district" type="text" class="mt-1 block w-full" v-model="form.district" required autofocus autocomplete="district" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="postcode" value="Postcode" />
                                    <BreezeInput id="postcode" type="text" class="mt-1 block w-full" v-model="form.postcode" autofocus autocomplete="postcode" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="city" value="City" />
                                    <BreezeInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" required autofocus autocomplete="city" />
                                </div>

                                <div class="m-4">
                                    <BreezeLabel for="country" value="Country" />
                                    <select v-model="form.country_code" class="mt-1 block w-full rounded-lg" required autofocus autocomplete="country" >
                                        <option v-for="country in countries" :value="country.code">{{ country.name }}</option>
                                    </select>
                                </div>

                                <div class="flex items-center justify-end m-4">
                                    <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Create
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
            countries: Object,
        },
        data() {
            return {
                form: this.$inertia.form({
                    address_1: null,
                    address_2: null,
                    district: null,
                    postcode: null,
                    city: null,
                    country_code: null,
                }),
            }
        },
        methods: {
            store() {
              this.form.post(route('addresses.store'));
            },
        },
    }
</script>
