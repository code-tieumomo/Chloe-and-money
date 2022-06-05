<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import {Head, useForm} from "@inertiajs/inertia-vue3";
import {nextTick, onMounted, reactive, ref, computed} from "vue";
import moment from "moment";
import {PerfectScrollbar} from "vue3-perfect-scrollbar";

const props = defineProps({
    isReady: Boolean,
    savingMoney: Array,
    spendingMoney: Array,
});

const percentage = computed(() => {
    const amount =
        props.savingMoney.reduce((prev, next) => prev + next.amount, 0) +
        props.spendingMoney.reduce(
            (prev, next) => prev + (next.amount >= 2000000 ? next.amount : 0),
            0,
        );
    const percentage = (amount / 100000000) * 100;

    return {
        amount,
        percentage: percentage <= 100 ? percentage : 100,
    };
});
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div v-if="false" class="max-w-7xl p-6 mx-auto">
            <div
                v-if="!isReady"
                class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"
                role="alert"
            >
                <svg
                    class="inline flex-shrink-0 mr-3 w-5 h-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div>
                    <span class="font-bold"
                    >You need at least one transaction to get started!</span
                    >
                </div>
            </div>

            <div
                v-else
                class="p-6 max-w-7xl mx-auto mb-4 bg-white rounded-lg border border-gray-200 shadow-md"
            >
                <p class="text-2xl font-bold mb-4">
                    Progress ({{ percentage.amount.toLocaleString() }})
                </p>
                <div class="w-full bg-gray-200 rounded-full">
                    <div
                        class="text-xs font-medium text-center p-0.5 px-2 leading-none rounded-full text-white transition-all duration-300 min-w-fit"
                        :class="
                            percentage.percentage <= 30
                                ? 'bg-red-500'
                                : percentage.percentage <= 60
                                ? 'bg-yellow-500'
                                : 'bg-green-500'
                        "
                        :style="`width: ${percentage.percentage}%`"
                    >
                        {{ percentage.percentage }}%
                    </div>
                </div>
            </div>

            <perfect-scrollbar
                v-if="spendingMoney.length > 0"
                class="relative mt-8 overflow-hidden shadow-md sm:rounded-lg"
            >
                <div>
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                        <tr>
                            <th scope="col" class="px-6 py-3">Amount</th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            class="bg-white border-b"
                            v-for="transaction in spendingMoney"
                            :key="transaction.id"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap"
                            >
                                {{ transaction.amount.toLocaleString() }}
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ transaction.description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{
                                    moment(transaction.created_at).format(
                                        "dddd, MMMM Do YYYY, HH:mm:ss",
                                    )
                                }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a
                                    href="#"
                                    class="font-medium text-blue-600 hover:underline"
                                >Edit</a
                                >
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </perfect-scrollbar>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style src="vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css"/>
