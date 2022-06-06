<script setup>
import {nextTick, onMounted, reactive, ref} from "vue";
import BreezeApplicationLogo from "@/Components/Logo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import {Link, useForm, usePage} from "@inertiajs/inertia-vue3";
import moment from "moment";

const showingNavigationDropdown = ref(false);

/**
 * Transaction modal
 */
const input = ref(null);
const modal = reactive({
    isOpen: false,
});

onMounted(() => {
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.isOpen) modal.isOpen = !modal.isOpen;
    });
});

async function toggleModal() {
    modal.isOpen = !modal.isOpen;
    await nextTick();
    if (modal.isOpen) input.value.focus();
}

const form = useForm({
    amount: "",
    type: "spending",
    group_id: 1,
    description: "",
    date: moment(new Date()).format("yyyy-MM-DD"),
});

function formatAmount() {
    let nf = new Intl.NumberFormat("en-US");
    form.amount = nf.format(Number(form.amount.replaceAll(",", "")));
}

function storeTransaction() {
    // form.transform((data) => ({
    //     ...data,
    //     rawAmount: Number(data.amount.replaceAll(",", "")),
    // })).post("/transaction", {
    //     preserveScroll: true,
    //     onSuccess: () => form.reset("amount") && form.reset("description"),
    // });
}

const groups = usePage().props.value.groups;
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')" class="flex items-center">
                                    <BreezeApplicationLogo
                                        class="block h-6 w-auto"
                                    />
                                    <span class="ml-2 font-semibold text-gray-600 text-cyan-500">cờ lâu i and money</span>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"
                            >
                                <BreezeNavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </BreezeNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <img
                                                    class="w-10 h-10 rounded-full"
                                                    :src="`https://avatars.dicebear.com/api/adventurer-neutral/${$page.props.auth.user.avatar}.svg`"
                                                    alt="Rounded avatar"
                                                />
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div
                                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out font-bold text-lg"
                                        >
                                            {{ $page.props.auth.user.name }}
                                        </div>
                                        <BreezeDropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="mr-2 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                                </svg>
                            </button>
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1">
                        <BreezeResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200">
                        <div class="p-4">
                            <div class="font-bold text-gray-800 text-sm">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                        <div class="space-y-1">
                            <BreezeResponsiveNavLink
                                class="w-full text-left"
                                :href="route('home')"
                                method="get"
                                as="button"
                            >
                                Setting
                            </BreezeResponsiveNavLink>
                        </div>
                        <div class="space-y-1">
                            <BreezeResponsiveNavLink
                                class="w-full text-left"
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main class="pb-[70px]">
                <slot/>
            </main>

            <!--Page Footer-->
            <div class="fixed bottom-0 left-0 right-0 h-16 bg-white shadow">
                <nav class="h-full flex items-center justify-around">
                    <Link :class="{ 'text-[#4dcfe0]': $page.url === '/dashboard' }" :href="route('dashboard')"
                          class="text-center text-gray-500 w-fit text-xs flex flex-col items-center">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"
                                  fill-rule="evenodd"/>
                            <path d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" fill-rule="evenodd"/>
                        </svg>
                    </Link>
                    <Link :href="route('dashboard')" class="text-center text-gray-500 w-fit text-xs flex flex-col items-center">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M1.5 2A1.5 1.5 0 0 0 0 3.5v2h6a.5.5 0 0 1 .5.5c0 .253.08.644.306.958.207.288.557.542 1.194.542.637 0 .987-.254 1.194-.542.226-.314.306-.705.306-.958a.5.5 0 0 1 .5-.5h6v-2A1.5 1.5 0 0 0 14.5 2h-13z"/>
                            <path
                                d="M16 6.5h-5.551a2.678 2.678 0 0 1-.443 1.042C9.613 8.088 8.963 8.5 8 8.5c-.963 0-1.613-.412-2.006-.958A2.679 2.679 0 0 1 5.551 6.5H0v6A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-6z"/>
                        </svg>
                    </Link>
                    <span class="text-center text-[#4dcfe0] w-fit cursor-pointer" @click="toggleModal">
                        <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                        </svg>
                    </span>
                    <Link :href="route('dashboard')" class="text-center text-gray-500 w-fit text-xs flex flex-col items-center">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/>
                            <path
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"/>
                        </svg>
                    </Link>
                    <Link :href="route('dashboard')" class="text-center text-gray-500 w-fit text-xs flex flex-col items-center">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                        </svg>
                    </Link>
                </nav>

                <!-- Main modal -->
                <Transition>
                    <div v-if="modal.isOpen"
                         id="authentication-modal"
                         aria-hidden="true"
                         class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full h-full md:inset-0 h-modal md:h-full bg-black/[.6]"
                         tabindex="-1"
                         @click="toggleModal"
                         @keydown.esc="toggleModal"
                    >
                        <div class="relative w-full h-full flex justify-center items-center">
                            <!-- Modal content -->
                            <div
                                class="relative bg-white w-full h-full"
                                @click.stop
                            >
                                <button
                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                    data-modal-toggle="authentication-modal"
                                    type="button"
                                    @click="toggleModal"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            clip-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            fill-rule="evenodd"
                                        ></path>
                                    </svg>
                                </button>
                                <div class="py-6 px-6 lg:px-8">
                                    <h3
                                        class="mb-4 text-xl font-medium text-gray-900"
                                    >
                                        Add new transaction
                                    </h3>
                                    <form
                                        class="space-y-6"
                                        @submit.prevent="storeTransaction"
                                    >
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900"
                                                for="amount"
                                            >Amount</label
                                            >
                                            <input
                                                id="amount"
                                                ref="input"
                                                v-model="form.amount"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                min="0"
                                                name="amount"
                                                placeholder="Amount"
                                                required
                                                type="text"
                                                @input="formatAmount"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900"
                                                for="type"
                                            >Transaction type</label
                                            >
                                            <select
                                                id="type"
                                                v-model="form.type"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            >
                                                <option selected value="spending">
                                                    Spending money
                                                </option>
                                                <option value="saving">
                                                    Saving money
                                                </option>
                                            </select>
                                        </div>
                                        <div v-if="form.type === 'spending'">
                                            <label class="block mb-2 text-sm font-medium text-gray-900"
                                                   for="group">Group</label>
                                            <select
                                                id="group"
                                                v-model="form.group_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            >
                                                <optgroup v-for="group in groups" :key="group.id" :label="group.name">
                                                    <option v-for="subGroup in group.subGroups" :key="subGroup.id" :value="subGroup.id">
                                                        {{ subGroup.name }}
                                                    </option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div v-if="form.type === 'spending'">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900"
                                                for="description"
                                            >Description</label
                                            >
                                            <textarea
                                                id="description"
                                                v-model="form.description"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Description"
                                                rows="4"
                                            ></textarea>
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900"
                                                for="description"
                                            >Date</label
                                            >
                                            <input
                                                id="date"
                                                type="date"
                                                v-model="form.date"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Description"
                                            >
                                        </div>
                                        <button
                                            :disabled="form.processing"
                                            class="w-full text-white bg-cyan-400 hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                            type="submit"
                                        >
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

option:disabled {
    color: #a0aec0;
    font-size: 12px;
}
</style>
