<script setup>
import {reactive, ref, watch} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import CategoryTreeItem from "@/Components/UI/CategoryTreeItem.vue";
import ProductCard from "@/Components/UI/ProductCard.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    categories: {
        type: Object,
        required: true,
    },
    products: {
        type: Object,
        required: true,
    },
    sortOptions: {
        type: Array,
        required: true,
    },
    sort: {
        type: String,
    },
});

defineEmits(['select-category'])

const selectedCategory = ref(null)
const goToCategory = (category) => {
    selectedCategory.value = category
}

const query = reactive({
    page: props.products.meta.current_page,
    sort: props.sort,
    category: selectedCategory
})

const reload = () => {
    router.get(route('categories.index'), query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}
watch(
    () => [query.sort, query.page, query.category],
    () => reload()
)
</script>

<template>
    <AppLayout title="Categories">
        <div class="space-y-8">
            <section class="border rounded-md border-default bg-elevated p-8 shadow-sm sm:p-8">
                <UBadge color="primary" variant="soft">
                    Product catalog
                </UBadge>
                <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-semibold tracking-tight text-highlighted">
                            Products
                        </h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">
                            Browse products by category, sort the catalog by name, price, or date.
                        </p>
                    </div>
                    <div class="w-full lg:w-64">
                        <label class="mb-2 block text-sm font-medium text-highlighted">
                            Sort products
                        </label>
                        <USelect
                            v-model="query.sort"
                            :items="props.sortOptions"
                            value-key="value"
                            label-key="label"
                            class="w-full"
                        />
                    </div>
                </div>
            </section>
            <section class="grid gap-6 lg:grid-cols-[18rem_1fr]">
                <aside class="lg:sticky lg:top-36 lg:self-start">
                    <div class="rounded-md border border-default bg-elevated p-4 shadow-sm">
                        <div class="mb-3 flex items-center gap-2 px-2">
                            <UIcon name="i-lucide-list-filter" class="size-4 text-primary"/>
                            <h2 class="text-sm font-semibold text-highlighted">
                                Categories
                            </h2>
                        </div>
                        <div class="space-y-1">
                            <div class="space-y-1">
                                <CategoryTreeItem
                                    v-for="category in props.categories.data"
                                    :key="category.slug"
                                    :category="category"
                                    :selected-category="selectedCategory"
                                    @select-category="goToCategory"
                                />
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="space-y-4" v-if="products.meta.total > 0">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm text-muted">
                            Showing {{ products.meta.total }} products
                        </p>
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
                </div>
                <div v-else>
                    <p class="text-red-600">No products have been found!</p>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
