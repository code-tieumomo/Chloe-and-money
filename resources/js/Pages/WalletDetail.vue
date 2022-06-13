<script setup>
import {defineProps, inject} from "vue";
import {Head, Link, useForm, usePage} from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import moment from "moment";

const swal = inject("$swal");

const props = defineProps({
    wallet: Object,
});

const form = useForm({
    name: props.wallet.name,
    amount: props.wallet.amount.toLocaleString(),
});

function formatAmount() {
    form.amount = form.amount.replaceAll(",", "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function storeWallet() {
    if (Number(form.amount.toString().replaceAll(",", "")) < 0) {
        swal({
            icon: "warning",
            title: "Warning",
            text: "Amount can not negative",
        })

        return;
    }

    form.transform((data) => ({
        ...data,
        rawAmount: Number(data.amount.toString().replaceAll(",", "")),
    })).put(`/wallets/${props.wallet.id}`, {
        preserveScroll: true,
        onSuccess: (page) => {
            console.log(page);
            swal({
                icon: "success",
                title: "Success",
                text: usePage().props.value.flash.success,
            });
        },
    });
}
</script>

<template>
    <Head :title="wallet.name"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1 class="text-xl font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="" viewBox="0 0 16 16">
                    <path
                        d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                </svg>
                Wallet
            </h1>
        </template>

        <!--<div v-if="$page.props.flash.success" class="mt-3 mx-2 font-semibold text-green-500">-->
        <!--    {{ $page.props.flash.success }}-->
        <!--</div>-->

        <form action="#" @submit.prevent="storeWallet">
            <div class="m-2 bg-white shadow rounded-md">
                <div class="px-4 py-2 flex gap-2 items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4 text-cyan-500" viewBox="0 0 16 16">
                        <path
                            d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                    </svg>
                    <input id="name" v-model="form.name" name="name" placeholder="Name"
                           required type="text"
                           class="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2 ml-2"/>
                </div>
            </div>

            <div class="m-2 bg-white shadow rounded-md">
                <div class="px-4 py-2 flex gap-2 items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4 text-cyan-500" viewBox="0 0 16 16">
                        <path
                            d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                    </svg>
                    <input id="amount" ref="input" v-model="form.amount" name="amount" placeholder="Amount"
                           required type="text" @input="formatAmount"
                           class="text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2 ml-2"/>
                </div>
            </div>

            <button type="submit" class="text-white bg-cyan-500 hover:bg-cyan-600 font-medium rounded-md text-xs px-4 py-2 float-right m-2" :disabled="form.processing">
                Save
            </button>
        </form>
    </BreezeAuthenticatedLayout>
</template>
