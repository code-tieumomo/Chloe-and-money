<script setup>
import {Head, Link} from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";

const props = defineProps({
    wallets: Array,
});
</script>

<template>
    <Head title="Wallets"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1 class="text-xl font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="" viewBox="0 0 16 16">
                    <path
                        d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                </svg>
                Your wallets
            </h1>
        </template>

        <div class="m-2 bg-white shadow rounded-md" v-for="wallet in wallets" :key="wallet.id">
            <div class="px-4 py-2 flex gap-2 items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4 text-cyan-500" viewBox="0 0 16 16">
                    <path
                        d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5V3zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a1.99 1.99 0 0 1-1-.268zM1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1z"/>
                </svg>
                <Link :href="route('wallets.show', {'id': wallet.id})" class="font-semibold">{{ wallet.name }}</Link>
            </div>
            <hr>
            <div class="px-4 py-2 flex gap-2 items-center text-sm justify-between">
                <span class="font-semibold text-sm">Amount:</span>
                <span>{{ wallet.amount.toLocaleString() }}</span>
            </div>
        </div>

        <button type="button" class="text-white bg-cyan-500 hover:bg-cyan-600 font-medium rounded-md text-xs px-4 py-2 float-right m-2">
            Add wallet
        </button>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>

</style>
