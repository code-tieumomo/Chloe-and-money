<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import {Head, Link} from "@inertiajs/inertia-vue3";
import Popper from "vue3-popper";
import {ref} from "vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps({
    wallets: Array,
    totalAmount: Number,
});
console.log(props.totalAmount);

const isShowWallet = ref(false);

function toggleShowWallet() {
    isShowWallet.value = !isShowWallet.value;
}

const chart = {
    series: [42, 47, 52, 58, 65],
    chartOptions: {
        chart: {
            width: "100%",
            type: "polarArea",
        },
        labels: ["Rose A", "Rose B", "Rose C", "Rose D", "Rose E"],
        fill: {
            opacity: 1,
        },
        stroke: {
            width: 1,
            colors: undefined,
        },
        yaxis: {
            show: false,
        },
        legend: {
            position: "bottom",
        },
        plotOptions: {
            polarArea: {
                rings: {
                    strokeWidth: 0,
                },
                spokes: {
                    strokeWidth: 0,
                },
            },
        },
        theme: {
            monochrome: {
                enabled: true,
                shadeTo: "light",
                shadeIntensity: 0.6,
                color: "#4dcfe0",
            },
        },
    },
};
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex">
                <img
                    class="w-10 h-10 rounded-full"
                    :src="`https://avatars.dicebear.com/api/adventurer-neutral/${$page.props.auth.user.avatar}.svg`"
                    alt="Rounded avatar"
                />
                <div class="flex flex-col ml-4">
                    <div class="flex items-center h-6">
                        <div class="font-semibold text-xl text-gray-600"
                             v-text="isShowWallet ? totalAmount.toLocaleString() : '************'"></div>
                        <svg v-if="!isShowWallet"
                             xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4 text-gray-500 ml-2 cursor-pointer"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2"
                             @click="toggleShowWallet"
                        >
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            />
                        </svg>
                        <svg v-if="isShowWallet"
                             xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4 text-gray-500 ml-2 cursor-pointer"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2"
                             @click="toggleShowWallet"
                        >
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                            />
                        </svg>
                    </div>
                    <div class="flex items-center text-xs text-gray-400">
                        <Popper hover offsetDistance="10" arrow offsetSkid="40" class="w-fit">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="16"
                                 height="16"
                                 fill="currentColor"
                                 class="mr-1 w-3 h-3"
                                 viewBox="0 0 16 16"
                            >
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"
                                />
                            </svg>
                            <template #content>
                                <div>Calculated by all your budgets</div>
                            </template>
                        </Popper>
                        Your current budget
                    </div>
                </div>
            </div>
        </template>

        <div class="m-2 bg-white shadow rounded-md">
            <div class="px-4 py-2 flex justify-between items-center text-xs">
                <span class="text-gray-500">Your wallets</span>
                <Link class="text-sm" :href="route('home')">View all</Link>
            </div>
            <hr>
            <div class="px-4 py-2 flex justify-between font-semibold">
                <span>{{ wallets[0].name }}</span>
                <span>{{ wallets[0].amount.toLocaleString() }}</span>
            </div>
        </div>

        <div class="mt-4">
            <span class="text-xs text-gray-500 mx-2">Spending report</span>
            <div class="mx-2 bg-white shadow rounded-md p-2">
                <VueApexCharts type="polarArea" :options="chart.chartOptions" :series="chart.series"></VueApexCharts>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style src="vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css"/>
<style>
:root {
    --popper-theme-background-color: #333333;
    --popper-theme-background-color-hover: #333333;
    --popper-theme-text-color: #ffffff;
    --popper-theme-border-radius: 4px;
    --popper-theme-padding: 0.5rem;
    --popper-theme-box-shadow: 0 6px 30px -6px rgba(0, 0, 0, 0.25);
}
</style>
