<script setup>
import {reactive, watch, watchEffect} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from "../../Components/UI/ProductCard.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    sortOptions: {
        type: Array,
        required: true,
    },
    search: {
        type: String,
        default: ''
    },
    sort: {
        type: String,
    }
})

const query = reactive({
    page: props.products.meta.current_page,
    sort: props.sort,
})
//console.log()
const reload = () => {
    router.get(route('products.index'), query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}

watch(
    () => [query.page, query.sort],
    reload
)

watch(
    () => props.search,
    (search) => {
        query.search = search
    }
)

watch(
    () => props.sort,
    (sort) => {
        query.sort = sort
    }
)

watch(
    () => props.products.meta.current_page,
    (page) => {
        query.page = page;
    }
)

</script>

<template>
    <AppLayout title="Products"
    >
        <div class="space-y-8">
            <section class="rounded-md border border-default bg-elevated p-6 shadow-sm sm:p-8">
                <UBadge color="primary" variant="soft">
                    Product catalog
                </UBadge>

                <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-semibold tracking-tight text-highlighted">
                            All products
                        </h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">
                            Browse the storefront catalog and sort products by name, price, or date.
                        </p>
                    </div>

                    <div class="w-full lg:w-64">
                        <label class="mb-2 block text-sm font-medium text-highlighted">
                            Sort products
                        </label>

                        <USelect
                            v-model="query.sort"
                            :items="sortOptions"
                            value-key="value"
                            label-key="label"
                            class="w-full"
                        />
                    </div>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <p class="text-sm text-muted">
                        Showing {{ $page.props.products.meta.to }} from {{ $page.props.products.meta.total }} products
                    </p>

                    <UButton
                        as="Link"
                        to="/categories"
                        color="neutral"
                        variant="outline"
                        icon="i-lucide-list-filter"
                    >
                        Browse categories
                    </UButton>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <ProductCard
                        v-for="product in products.data"
                        :product="product"
                    />
                </div>
                <UPagination
                    v-model:page="query.page"
                    :total="products.meta.total"
                    :items-per-page="products.meta.per_page"
                    :sibling-count="3"
                />
            </section>
        </div>
    </AppLayout>
</template>
