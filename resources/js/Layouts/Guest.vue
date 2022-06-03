<script setup>
import Logo from "@/Components/Logo.vue";
import {Link} from "@inertiajs/inertia-vue3";
</script>

<template>
    <div class="landing-background flex flex-col h-screen">
        <nav class="bg-white border-gray-200">
            <div class="container p-4 flex flex-wrap justify-between items-center mx-auto">
                <Link :href="route('home')" class="flex items-center">
                    <Logo class="w-8 h-8 fill-current text-gray-500 mr-2"/>
                    <span class="self-center text-xl font-semibold whitespace-nowrap">cờ lâu i and money</span>
                </Link>
                <div v-if="!$page.props.auth.user.name" class="sm:flex gap-4 items-center md:order-2 hidden">
                    <Link as="button"
                          :href="route('register')"
                          class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center font-bold">
                        Register
                    </Link>

                    <Link as="button"
                          :href="route('login')"
                          class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center font-bold">
                        Login
                    </Link>
                </div>
            </div>
        </nav>

        <div class="container mx-auto px-2 sm:px-6 py-10 flex-1">
            <slot></slot>
        </div>

        <footer class="w-full p-4 bg-white sm:p-6">
            <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center">© 2022 <Link :href="route('home')" class="hover:underline">cờ lâu i and money™</Link>. All Rights Reserved.
            </span>
                <div class="flex mt-4 space-x-4 sm:justify-center sm:mt-0">
                    <a href="https://github.com/code-tieumomo" target="_blank" class="text-gray-500 hover:text-gray-900">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/pyl.walker" target="_blank" class="text-gray-500 hover:text-gray-900">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.landing-background {
    background-image: url("../Assets/landing-background.png");
    background-size: contain;
}
</style>
