<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Search products, brands, and categories',
    },
});

const emit = defineEmits(['update:modelValue', 'submit']);

const query = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

const submit = () => {
    emit('submit', query.value.trim());
};
</script>

<template>
    <form
        class="w-full"
        action="/search"
        method="get"
        role="search"
        @submit.prevent="submit"
    >
        <label class="sr-only" for="site-search">Search products</label>

        <UInput
            id="site-search"
            v-model="query"
            type="search"
            name="q"
            autocomplete="off"
            :placeholder="placeholder"
            size="xl"
            icon="i-lucide-search"
            class="w-full"
        >
            <template #trailing>
                <UButton
                    type="submit"
                    color="primary"
                    variant="solid"
                    size="sm"
                    aria-label="Search"
                >
                    Search
                </UButton>
            </template>
        </UInput>
    </form>
</template>
