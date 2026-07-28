<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const isOpen = ref(false);
const menuRef = ref(null);

const close = () => {
    isOpen.value = false;
};

const toggle = () => {
    isOpen.value = !isOpen.value;
};

const handleClickOutside = (event) => {
    if (!menuRef.value || menuRef.value.contains(event.target)) {
        return;
    }

    close();
};

const handleKeydown = (event) => {
    if (event.key === 'Escape') {
        close();
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
    <div ref="menuRef" class="relative">
        <UButton
            type="button"
            color="neutral"
            variant="outline"
            size="md"
            trailing-icon="i-lucide-chevron-down"
            :aria-expanded="isOpen"
            aria-haspopup="menu"
            @click.stop="toggle"
        >
            Categories
        </UButton>

        <div
            v-if="isOpen"
            class="absolute left-0 top-full z-200 mt-3 w-88 rounded-md border border-slate-200 bg-white p-2 shadow-2xl transition-colors dark:border-slate-800 dark:bg-slate-900"
            role="menu"
        >
            <div class="px-3 py-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                    Browse categories
                </p>
            </div>

            <div class="space-y-1">
                <Link
                    v-for="category in categories"
                    :key="category.href"
                    :href="category.href"
                    class="block rounded-2xl px-3 py-3 transition hover:bg-slate-50 focus:outline-none focus-visible:bg-slate-50 dark:hover:bg-slate-800 dark:focus-visible:bg-slate-800"
                    role="menuitem"
                    @click="close"
                >
                    <span class="block text-sm font-medium text-slate-950 dark:text-white">
                        {{ category.label }}
                    </span>
                    <span class="block text-sm text-slate-500 dark:text-slate-400">
                        {{ category.description }}
                    </span>
                </Link>
            </div>
        </div>
    </div>
</template>
