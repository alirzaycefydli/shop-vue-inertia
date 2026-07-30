<script setup>
defineProps({
    product: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <Link
        :href="route('products.show', product.slug)"
        class="rounded-md border border-slate-200 bg-white p-5 shadow-sm transition hover:border-slate-300 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:ring-offset-2 focus-visible:ring-offset-white"
    >
        <div class="aspect-5/5 rounded-md bg-slate-100">
            <img :src="product.image" :alt="product.name" class="rounded-md object-cover aspect-5/5 w-full">
        </div>
        <div class="mt-4 flex items-start justify-between gap-3">
            <div>
                <h3 class="text-sm font-semibold text-slate-950">{{ product.name }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ product.price }}</p>
            </div>
            <div
                class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700">
                {{ product.category }}
            </div>
        </div>
    </Link>
</template>
