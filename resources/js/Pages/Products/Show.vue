<script setup>
import { computed, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    slug: {
        type: String,
        required: true,
    },
});

const products = [
    {
        slug: 'structured-overshirt',
        name: 'Structured Overshirt',
        brand: 'Northline Studio',
        price: 128,
        compareAtPrice: 168,
        rating: 4.9,
        reviewCount: 128,
        category: 'Men',
        description: 'A clean structured overshirt made for layering through changing seasons. Cut with a relaxed silhouette and finished with durable utility pockets.',
        colors: ['Slate', 'Stone', 'Forest'],
        sizes: ['XS', 'S', 'M', 'L', 'XL'],
        images: ['Front', 'Back', 'Detail', 'Styled'],
        details: [
            'Relaxed fit',
            'Mid-weight cotton blend',
            'Button front closure',
            'Two chest pockets',
            'Machine washable',
        ],
    },
    {
        slug: 'everyday-leather-tote',
        name: 'Everyday Leather Tote',
        brand: 'Atelier Carry',
        price: 184,
        compareAtPrice: 220,
        rating: 4.8,
        reviewCount: 94,
        category: 'Accessories',
        description: 'A minimal leather tote designed for daily carry, work essentials, and weekend errands.',
        colors: ['Black', 'Tan', 'Oxblood'],
        sizes: ['One Size'],
        images: ['Front', 'Interior', 'Handle', 'Styled'],
        details: [
            'Full-grain leather',
            'Internal zip pocket',
            'Fits a 14-inch laptop',
            'Magnetic closure',
            'Dust bag included',
        ],
    },
    {
        slug: 'minimal-runner',
        name: 'Minimal Runner',
        brand: 'Ground Form',
        price: 156,
        compareAtPrice: 190,
        rating: 4.9,
        reviewCount: 211,
        category: 'Footwear',
        description: 'A lightweight everyday sneaker with clean lines, cushioned support, and versatile styling.',
        colors: ['White', 'Black', 'Sand'],
        sizes: ['40', '41', '42', '43', '44', '45'],
        images: ['Side', 'Top', 'Sole', 'Styled'],
        details: [
            'Breathable upper',
            'Cushioned midsole',
            'Rubber outsole',
            'Padded collar',
            'True to size',
        ],
    },
    {
        slug: 'relaxed-tailored-trouser',
        name: 'Relaxed Tailored Trouser',
        brand: 'Line & Form',
        price: 142,
        compareAtPrice: 172,
        rating: 5.0,
        reviewCount: 76,
        category: 'Women',
        description: 'A soft tailored trouser with a relaxed leg, clean waistband, and polished drape.',
        colors: ['Charcoal', 'Cream', 'Navy'],
        sizes: ['XS', 'S', 'M', 'L'],
        images: ['Front', 'Back', 'Waistband', 'Styled'],
        details: [
            'Relaxed straight leg',
            'Pressed front crease',
            'Side pockets',
            'Hook and zip closure',
            'Dry clean recommended',
        ],
    },
];

const product = computed(() =>
    products.find((item) => item.slug === props.slug) ?? products[0],
);

const selectedImage = ref(0);
const selectedColor = ref(product.value.colors[0]);
const selectedSize = ref(product.value.sizes[0]);

const formattedPrice = computed(() => `$${product.value.price}`);
const formattedCompareAtPrice = computed(() => `$${product.value.compareAtPrice}`);
</script>

<template>
    <AppLayout :title="product.name">
        <div class="space-y-8">
            <nav class="flex items-center gap-2 text-sm text-muted">
                <Link href="/" class="hover:text-highlighted">Home</Link>
                <UIcon name="i-lucide-chevron-right" class="size-4" />
                <Link href="/products" class="hover:text-highlighted">Products</Link>
                <UIcon name="i-lucide-chevron-right" class="size-4" />
                <span class="text-highlighted">{{ product.name }}</span>
            </nav>

            <section class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="space-y-4">
                    <div class="flex aspect-square items-center justify-center rounded-xl border border-default bg-muted shadow-sm">
                        <div class="text-center">
                            <UIcon name="i-lucide-image" class="mx-auto size-16 text-muted" />
                            <p class="mt-3 text-sm font-medium text-muted">
                                {{ product.images[selectedImage] }} image
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-3">
                        <button
                            v-for="(image, index) in product.images"
                            :key="image"
                            type="button"
                            class="flex aspect-square items-center justify-center rounded-xl border bg-elevated text-sm font-medium transition"
                            :class="selectedImage === index ? 'border-primary text-primary' : 'border-default text-muted hover:border-accented hover:text-highlighted'"
                            @click="selectedImage = index"
                        >
                            {{ image }}
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <UBadge color="primary" variant="soft">
                            {{ product.category }}
                        </UBadge>

                        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-highlighted sm:text-4xl">
                            {{ product.name }}
                        </h1>

                        <p class="mt-2 text-sm text-muted">
                            by {{ product.brand }}
                        </p>

                        <div class="mt-4 flex items-center gap-3">
                            <div class="flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-sm font-medium text-amber-700 dark:bg-amber-400/10 dark:text-amber-300">
                                <UIcon name="i-lucide-star" class="size-4 fill-current" />
                                {{ product.rating }}
                            </div>

                            <span class="text-sm text-muted">
                                {{ product.reviewCount }} reviews
                            </span>
                        </div>
                    </div>

                    <div class="flex items-end gap-3">
                        <p class="text-3xl font-semibold text-highlighted">
                            {{ formattedPrice }}
                        </p>
                        <p class="pb-1 text-base text-muted line-through">
                            {{ formattedCompareAtPrice }}
                        </p>
                    </div>

                    <p class="text-base leading-7 text-muted">
                        {{ product.description }}
                    </p>

                    <div class="space-y-3">
                        <p class="text-sm font-semibold text-highlighted">
                            Color: {{ selectedColor }}
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <UButton
                                v-for="color in product.colors"
                                :key="color"
                                type="button"
                                :color="selectedColor === color ? 'primary' : 'neutral'"
                                :variant="selectedColor === color ? 'solid' : 'outline'"
                                @click="selectedColor = color"
                            >
                                {{ color }}
                            </UButton>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-sm font-semibold text-highlighted">
                            Size: {{ selectedSize }}
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <UButton
                                v-for="size in product.sizes"
                                :key="size"
                                type="button"
                                :color="selectedSize === size ? 'primary' : 'neutral'"
                                :variant="selectedSize === size ? 'solid' : 'outline'"
                                @click="selectedSize = size"
                            >
                                {{ size }}
                            </UButton>
                        </div>
                    </div>

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

                        <ul class="mt-4 space-y-3">
                            <li
                                v-for="detail in product.details"
                                :key="detail"
                                class="flex items-start gap-3 text-sm text-muted"
                            >
                                <UIcon name="i-lucide-check" class="mt-0.5 size-4 text-success" />
                                <span>{{ detail }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
