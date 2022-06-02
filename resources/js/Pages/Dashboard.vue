<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import {Head, useForm} from "@inertiajs/inertia-vue3";
import {nextTick, onMounted, reactive, ref, computed} from "vue";
import moment from "moment";

const props = defineProps({
    isReady: Boolean,
    savingMoney: Array,
    spendingMoney: Array,
});

const percentage = computed(() => {
    const amount = props.savingMoney.reduce((prev, next) => prev + next.amount, 0) + props.spendingMoney.reduce((prev, next) => prev + (next.amount >= 2000000 ? next.amount : 0), 0);
    const percentage = (amount / 100000000) * 100;

    return {
        amount,
        percentage: percentage <= 100 ? percentage : 100,
    };
});

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
    description: "",
});

function formatAmount() {
    let nf = new Intl.NumberFormat("en-US");
    form.amount = nf.format(Number(form.amount.replaceAll(",", "")));
}

function storeTransaction() {
    form
        .transform((data) => ({
            ...data,
            rawAmount: Number(data.amount.replaceAll(",", "")),
        }))
        .post("/transaction", {
            preserveScroll: true,
            onSuccess: () => form.reset("amount") && form.reset("description"),
        });
}
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="max-w-7xl p-6 mx-auto">
            <div v-if="!isReady" class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <svg class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          clip-rule="evenodd"></path>
                </svg>
                <div>
                    <span class="font-bold">You need at least one transaction to get started!</span>
                </div>
            </div>

            <div v-else class="p-6 max-w-7xl mx-auto mb-4 bg-white rounded-lg border border-gray-200 shadow-md">
                <p class="text-2xl font-bold mb-4">Progress ({{ percentage.amount.toLocaleString() }})</p>
                <div class="w-full bg-gray-200 rounded-full">
                    <div class="text-xs font-medium text-center p-0.5 leading-none rounded-full text-white transition-all duration-300"
                         :class="percentage.percentage <= 30 ? 'bg-red-500' : percentage.percentage <= 60 ? 'bg-yellow-500' : 'bg-green-500'"
                         :style="`width: ${percentage.percentage}%`">
                        {{ percentage.percentage }}%
                    </div>
                </div>
            </div>

            <!-- Modal toggle -->
            <button
                class="block ml-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                type="button" data-modal-toggle="authentication-modal"
                @click="toggleModal"
            >
                Add transaction
            </button>

            <!-- Main modal -->
            <Transition>
                <div v-if="modal.isOpen" id="authentication-modal" tabindex="-1" aria-hidden="true"
                     class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full h-full md:inset-0 h-modal md:h-full bg-black/[.6]"
                     @click="toggleModal"
                     @keydown.esc="toggleModal"
                >
                    <div class="relative p-4 w-full h-full flex justify-center items-center">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow w-full max-w-md" @click.stop>
                            <button type="button"
                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                    data-modal-toggle="authentication-modal"
                                    @click="toggleModal"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="py-6 px-6 lg:px-8">
                                <h3 class="mb-4 text-xl font-medium text-gray-900">Add new transaction</h3>
                                <form class="space-y-6" @submit.prevent="storeTransaction">
                                    <div>
                                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900">Amount</label>
                                        <input ref="input"
                                               type="text" name="amount" id="amount"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                               placeholder="Amount" min="0" required v-model="form.amount"
                                               @input="formatAmount">
                                    </div>
                                    <div>
                                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Transaction type</label>
                                        <select id="type"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                v-model="form.type">
                                            <option value="spending" selected>Spending money</option>
                                            <option value="saving">Saving money</option>
                                        </select>
                                    </div>
                                    <div v-if="form.type === 'spending'">
                                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                        <textarea id="description" rows="4"
                                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Description" v-model="form.description"></textarea>
                                    </div>
                                    <button type="submit"
                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                            :disabled="form.processing">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>

            <div v-if="spendingMoney.length > 0" class="relative mt-8 overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b" v-for="transaction in spendingMoney" :key="transaction.id">
                        <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                            {{ transaction.amount.toLocaleString() }}
                        </th>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ transaction.description }}
                        </td>
                        <td class="px-6 py-4">
                            {{ moment(transaction.created_at).format("dddd, MMMM Do YYYY, HH:mm:ss") }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateY(20px);
}
</style>
