<script setup>
import { computed } from 'vue';
import CategoryMenu from './CategoryMenu.vue';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        required: true,
    },
});

const secondaryItems = computed(() =>
    props.items.filter((item) => item.label !== 'Home'),
);
</script>

<template>
    <nav
        aria-label="Primary"
        class="relative z-50 border-t border-slate-200 bg-white/95 backdrop-blur transition-colors dark:border-slate-800 dark:bg-slate-950/95"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 overflow-visible py-3">
                <UButton
                    as="Link"
                    to="/"
                    color="primary"
                    variant="solid"
                    size="md"
                    icon="i-lucide-home"
                >
                    Home
                </UButton>

                <CategoryMenu :categories="categories" />

                <UButton
                    v-for="item in secondaryItems"
                    :key="item.href"
                    as="Link"
                    :to="item.href"
                    color="neutral"
                    variant="ghost"
                    size="md"
                >
                    {{ item.label }}
                </UButton>
            </div>
        </div>
    </nav>
</template>
