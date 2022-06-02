<script>
import GuestLayout from "@/Layouts/Guest.vue";

export default {
    layout: GuestLayout,
};
</script>

<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import {Head, Link, useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register"/>

    <div class="h-full flex flex-col justify-center px-5 max-w-lg mx-auto">
        <p class="text-5xl mb-5">Register</p>

        <span class="bg-gray-100 text-gray-800 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded w-fit mb-5">
            Already registered? Let&nbsp;
            <Link :href="route('login')" class="inline-flex text-[#4dcfe0] mr-1">
                Login
            </Link>
        </span>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="name" value="Name"/>
                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name"/>
            </div>

            <div class="mt-4">
                <BreezeLabel for="email" value="Email"/>
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username"/>
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Password"/>
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="Confirm Password"/>
                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password"/>
            </div>

            <div class="flex items-center justify-end gap-4 mt-4">
                <BreezeButton
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-fit px-5 py-2.5 text-center"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </BreezeButton>
            </div>
        </form>
    </div>
</template>
