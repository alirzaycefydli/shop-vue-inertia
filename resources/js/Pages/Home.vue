<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from "../Components/UI/ProductCard.vue";

defineProps({
    products: {
        type: Object,
    },
})
</script>

<template>
    <AppLayout title="Home">
        <section class="mt-10 space-y-6">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-950 dark:text-slate-100">Featured
                    products</h2>
                <p class="mt-2 text-sm text-slate-600">The products we have selected for you which you may like.</p>
            </div>

            <div v-if="Object.keys(products.data).length > 0" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <ProductCard
                    v-for="product in products.data"
                    :key="product.slug"
                    :product="product"
                />
            </div>
            <div v-else>
                <p class="text-red-600">No products have been found!</p>
            </div>
        </section>
    </AppLayout>
</template>
