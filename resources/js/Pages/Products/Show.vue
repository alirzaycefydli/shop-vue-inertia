<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ImageSlider from "../../Components/UI/ImageSlider.vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout :title="product.data.name">
        <div class="space-y-8">
            <nav class="flex items-center gap-2 text-sm text-muted">
                <Link :href="route('home')" class="hover:text-highlighted">Home</Link>
                <UIcon name="i-lucide-chevron-right" class="size-4"/>
                <Link :href="route('products.index')" class="hover:text-highlighted">Products</Link>
                <template v-for="category in product.data.category_breadcrumbs">
                    <UIcon name="i-lucide-chevron-right" class="size-4"/>
                    <Link :href="route('categories.index', category.slug)" class="text-highlighted">
                        {{ category.name }}
                    </Link>
                </template>
                <UIcon name="i-lucide-chevron-right" class="size-4"/>
                <span class="text-highlighted">{{ product.data.name }}</span>
            </nav>

            <section class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="space-y-3">
                    <div
                        class="rounded-xl">
                        <ImageSlider :items="product.data.images"/>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <div class="mt-4 flex items-center gap-3">
                            <div
                                class="flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-sm font-medium text-amber-700 dark:bg-amber-400/10 dark:text-amber-300">
                                {{ product.data.primary_category.name }}
                            </div>
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-highlighted sm:text-4xl">
                            {{ product.data.name }}
                        </h1>
                    </div>

                    <div class="flex items-end gap-3">
                        <p class="text-3xl font-semibold text-highlighted">
                            {{ product.data.price }}
                        </p>
                    </div>

                    <p class="text-base leading-7 text-muted">
                        {{ product.data.description }}
                    </p>


                    <div class="flex flex-col gap-3 sm:flex-row">
                        <UButton
                            color="primary"
                            size="xl"
                            icon="i-lucide-shopping-cart"
                            class="justify-center"
                        >
                            Add to cart
                        </UButton>

                        <UButton
                            color="neutral"
                            variant="outline"
                            size="xl"
                            icon="i-lucide-heart"
                            class="justify-center"
                        >
                            Add to wishlist
                        </UButton>
                    </div>

                    <div class="rounded-md border border-default bg-elevated p-5">
                        <h2 class="text-sm font-semibold text-highlighted">
                            Product details
                        </h2>

                        <p class="mt-4 space-y-3 text-sm text-muted">
                            {{ product.data.detailed_description }}
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
