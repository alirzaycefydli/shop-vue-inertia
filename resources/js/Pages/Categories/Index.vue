<script setup>
import { computed, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    category: {
        type: String,
        default: null,
    },
});

const categories = [
    { label: 'All Products', value: null, count: 8 },
    { label: 'Men', value: 'men', count: 2 },
    { label: 'Women', value: 'women', count: 2 },
    { label: 'Footwear', value: 'footwear', count: 2 },
    { label: 'Accessories', value: 'accessories', count: 2 },
];

const products = [
    {
        name: 'Structured Overshirt',
        slug: 'structured-overshirt',
        category: 'men',
        categoryLabel: 'Men',
        price: 128,
        rating: 4.9,
        description: 'A relaxed overshirt for everyday layering.',
    },
    {
        name: 'Utility Chore Jacket',
        slug: 'utility-chore-jacket',
        category: 'men',
        categoryLabel: 'Men',
        price: 164,
        rating: 4.7,
        description: 'Durable outer layer with utility pockets.',
    },
    {
        name: 'Relaxed Tailored Trouser',
        slug: 'relaxed-tailored-trouser',
        category: 'women',
        categoryLabel: 'Women',
        price: 142,
        rating: 5.0,
        description: 'Soft tailoring with a relaxed modern fit.',
    },
    {
        name: 'Ribbed Knit Cardigan',
        slug: 'ribbed-knit-cardigan',
        category: 'women',
        categoryLabel: 'Women',
        price: 118,
        rating: 4.6,
        description: 'Layer-ready knit with clean rib texture.',
    },
    {
        name: 'Minimal Runner',
        slug: 'minimal-runner',
        category: 'footwear',
        categoryLabel: 'Footwear',
        price: 156,
        rating: 4.9,
        description: 'Lightweight sneaker with cushioned support.',
    },
    {
        name: 'Suede Chelsea Boot',
        slug: 'suede-chelsea-boot',
        category: 'footwear',
        categoryLabel: 'Footwear',
        price: 212,
        rating: 4.8,
        description: 'Refined boot with everyday comfort.',
    },
    {
        name: 'Everyday Leather Tote',
        slug: 'everyday-leather-tote',
        category: 'accessories',
        categoryLabel: 'Accessories',
        price: 184,
        rating: 4.8,
        description: 'Minimal tote for work and daily carry.',
    },
    {
        name: 'Compact Card Wallet',
        slug: 'compact-card-wallet',
        category: 'accessories',
        categoryLabel: 'Accessories',
        price: 64,
        rating: 4.5,
        description: 'Slim wallet with practical organization.',
    },
];

const selectedCategory = ref(props.category);
const sortBy = ref('name-asc');

const sortOptions = [
    { label: 'Name: A to Z', value: 'name-asc' },
    { label: 'Name: Z to A', value: 'name-desc' },
    { label: 'Price: Low to High', value: 'price-asc' },
    { label: 'Price: High to Low', value: 'price-desc' },
    { label: 'Rating: High to Low', value: 'rating-desc' },
];

const selectedCategoryLabel = computed(() => {
    const category = categories.find((item) => item.value === selectedCategory.value);

    return category?.label ?? 'All Products';
});

const filteredProducts = computed(() => {
    const filtered = selectedCategory.value
        ? products.filter((product) => product.category === selectedCategory.value)
        : [...products];

    return filtered.sort((first, second) => {
        if (sortBy.value === 'name-asc') {
            return first.name.localeCompare(second.name);
        }

        if (sortBy.value === 'name-desc') {
            return second.name.localeCompare(first.name);
        }

        if (sortBy.value === 'price-asc') {
            return first.price - second.price;
        }

        if (sortBy.value === 'price-desc') {
            return second.price - first.price;
        }

        if (sortBy.value === 'rating-desc') {
            return second.rating - first.rating;
        }

        return 0;
    });
});

const setCategory = (category) => {
    selectedCategory.value = category;
};
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
                            Shop {{ selectedCategoryLabel }}
                        </h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">
                            Browse products by category, compare prices, and sort the catalog by name, price, or rating.
                        </p>
                    </div>

                    <div class="w-full lg:w-64">
                        <label class="mb-2 block text-sm font-medium text-highlighted">
                            Sort products
                        </label>

                        <USelect
                            v-model="sortBy"
                            :items="sortOptions"
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
                            <UIcon name="i-lucide-list-filter" class="size-4 text-primary" />
                            <h2 class="text-sm font-semibold text-highlighted">
                                Categories
                            </h2>
                        </div>

                        <div class="space-y-1">
                            <button
                                v-for="category in categories"
                                :key="category.label"
                                type="button"
                                class="flex w-full items-center justify-between rounded-sm px-3 py-3 text-left text-sm transition"
                                :class="selectedCategory === category.value ? 'bg-primary text-inverted' : 'text-muted hover:bg-muted hover:text-highlighted'"
                                @click="setCategory(category.value)"
                            >
                                <span>{{ category.label }}</span>
                                <UBadge
                                    :color="selectedCategory === category.value ? 'neutral' : 'primary'"
                                    variant="soft"
                                    size="xs"
                                >
                                    {{ category.count }}
                                </UBadge>
                            </button>
                        </div>
                    </div>
                </aside>

                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm text-muted">
                            Showing {{ filteredProducts.length }} products
                        </p>

                        <UButton
                            color="neutral"
                            variant="ghost"
                            icon="i-lucide-sliders-horizontal"
                        >
                            Filters
                        </UButton>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        <Link
                            v-for="product in filteredProducts"
                            :key="product.slug"
                            :href="`/products/${product.slug}`"
                            class="group rounded-md border border-default bg-elevated p-8 shadow-sm transition hover:border-accented hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
                        >
                            <div class="flex aspect-4/5 items-center justify-center rounded-md bg-muted transition group-hover:bg-accented">
                                <UIcon name="i-lucide-package" class="size-12 text-muted" />
                            </div>

                            <div class="mt-4 space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <UBadge color="primary" variant="soft" size="xs">
                                            {{ product.categoryLabel }}
                                        </UBadge>

                                        <h3 class="mt-2 text-sm font-semibold text-highlighted">
                                            {{ product.name }}
                                        </h3>
                                    </div>

                                    <div class="flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 dark:bg-amber-400/10 dark:text-amber-300">
                                        <UIcon name="i-lucide-star" class="size-3 fill-current" />
                                        {{ product.rating }}
                                    </div>
                                </div>

                                <p class="text-sm leading-6 text-muted">
                                    {{ product.description }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <p class="text-base font-semibold text-highlighted">
                                        ${{ product.price }}
                                    </p>

                                    <span class="inline-flex items-center gap-1 text-sm font-medium text-primary">
                                        View
                                        <UIcon name="i-lucide-arrow-right" class="size-4" />
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
