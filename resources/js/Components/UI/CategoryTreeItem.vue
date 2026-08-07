<script setup>
import {ref, watch} from "vue";

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
    selectedCategory: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(['select-category'])

const open = ref(false);

const containsCategory = (category, selectedSlug) => {
    if (category.slug === selectedSlug) {
        return true
    }

    return category.children?.some(child =>
        containsCategory(child, selectedSlug)
    )
}

watch(
    () => props.selectedCategory,
    () => {
        open.value = containsCategory(
            props.category,
            props.selectedCategory
        )
    },
    {immediate: true}
)
</script>

<template>
    <div>
        <div class="flex items-center justify-between rounded-md hover:bg-muted">
            <!-- Category link -->
            <button
                type="button"
                class="flex-1 px-3 py-2 text-left text-sm cursor-pointer"
                :class="
                    selectedCategory === category.slug
                        ? 'bg-primary/10 text-primary font-medium border-l-2 border-primary'
                        : 'text-muted hover:bg-muted hover:text-highlighted'
                "
                @click="emit('select-category', category.slug)"
            >
                {{ category.name }}
            </button>

            <!-- Expand button -->
            <button
                v-if="category.children?.length"
                type="button"
                class="py-2 hover:bg-elevated hover:text-primary cursor-pointer"
                @click.stop="open = !open"
            >
                <UIcon
                    name="i-lucide-chevron-right"
                    class="size-4 transition-transform"
                    :class="{ 'rotate-90': open }"
                />
            </button>
        </div>

        <!-- Children -->
        <div
            v-if="open && category.children?.length"
            class="ml-4 border-l border-default pl-3"
        >
            <CategoryTreeItem
                v-for="child in category.children"
                :key="child.slug"
                :category="child"
                :selected-category="selectedCategory"
                @select-category="emit('select-category', $event)"
            />
        </div>
    </div>
</template>
