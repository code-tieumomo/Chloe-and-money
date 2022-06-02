<script>
import GuestLayout from "@/Layouts/Guest.vue";

export default {
    layout: GuestLayout,
};
</script>

<script setup>
import {Head, Link} from "@inertiajs/inertia-vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    isLogin: Boolean,
});
</script>

<template>
    <Head title="Welcome"/>

    <div class="flex align-center h-full flex-col sm:flex-row justify-center px-2">
        <div class="w-full sm:w-3/6 flex flex-col gap-1 my-auto">
            <span v-if="!isLogin" class="bg-gray-100 text-gray-800 text-md font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 w-fit">
                <Link :href="route('login')" class="inline-flex text-[#4dcfe0] mr-1">
                    Login
                </Link>
                for more features
            </span>
            <h1 class="text-7xl font-bold mt-2 text-gray-700">cờ lâu i and money</h1>
            <p class="pr-4 text-sm text-gray-700 mt-5">
                Ever dream of having a nice trip to Paris with your love, new flagship smartphone, new car, travel around the world or maybe your retirement plan? Let's make it happen with our Cờ lâu i and money tracker app.
                <br>
                With 'Cờ lâu i and money' it's super easy to plan and manage your savings, just create your goal and track every time you save money with this simple but powerful app.
            </p>
            <Link :href="route('dashboard')"
                  as="button"
                  class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-lg px-5 py-2.5 text-center mt-4 w-fit font-bold">
                Get started
            </Link>
        </div>
        <img class="hidden sm:block w-3/6" src="@/Assets/landing.svg" alt="Landing">
    </div>
</template>
