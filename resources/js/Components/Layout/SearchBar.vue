<script setup>
import {ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    placeholder: {
        type: String,
        default: 'Search products, brands, and categories',
    },
});

const emit = defineEmits(['search']);

const page = usePage()

const searchInput = ref(page.props.search ?? '')

watch(
    () => page.props.search,
    (value) => {
        searchInput.value = value ?? ''
    }
)

const submit = () => {
    emit('search', searchInput.value.trim())
}

</script>

<template>
        <UInput
            id="site-search"
            v-model="searchInput"
            type="search"
            name="q"
            autocomplete="off"
            :placeholder="placeholder"
            size="xl"
            icon="i-lucide-search"
            class="w-full"
            @keyup.enter="submit"
        >
            <template #trailing>
                <UButton
                    type="submit"
                    color="primary"
                    variant="solid"
                    size="sm"
                    aria-label="Search"
                    @click="submit"
                >
                    Search
                </UButton>
            </template>
        </UInput>
</template>
