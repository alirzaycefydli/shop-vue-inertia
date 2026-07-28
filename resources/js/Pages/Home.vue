<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const products = [
    {name: 'Structured Overshirt', price: '$128', rating: '4.9', href: '/products/structured-overshirt'},
    {name: 'Everyday Leather Tote', price: '$184', rating: '4.8', href: '/products/everyday-leather-tote'},
    {name: 'Minimal Runner', price: '$156', rating: '4.9', href: '/products/minimal-runner'},
    {name: 'Relaxed Tailored Trouser', price: '$142', rating: '5.0', href: '/products/relaxed-tailored-trouser'},

];
</script>

<template>
    <AppLayout title="Home">
        <section class="mt-10 space-y-6">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-950 dark:text-slate-100">Featured
                    products</h2>
                <p class="mt-2 text-sm text-slate-600">A compact product grid that can later be backed by API data.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <Link
                    v-for="product in products"
                    :key="product.href"
                    :href="product.href"
                    class="rounded-md border border-slate-200 bg-white p-5 shadow-sm transition hover:border-slate-300 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:ring-offset-2 focus-visible:ring-offset-white"
                >
                    <div class="aspect-4/5 rounded-md bg-slate-100"></div>
                    <div class="mt-4 flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-950">{{ product.name }}</h3>
                            <p class="mt-1 text-sm text-slate-600">{{ product.price }}</p>
                        </div>
                        <div
                            class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700">
                            <span aria-hidden="true">★</span>
                            {{ product.rating }}
                        </div>
                    </div>
                </Link>
            </div>
        </section>
    </AppLayout>
</template>
