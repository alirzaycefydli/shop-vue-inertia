<script setup>
const props = defineProps({
    count: {
        type: Number,
        default: 0,
    },
    href: {
        type: String,
        default: '/cart',
    },
});

const countLabel = (count) => (count > 99 ? '99+' : String(count));
</script>

<template>
    <UButton
        :to="props.href"
        as="Link"
        color="neutral"
        variant="outline"
        square
        size="lg"
        class="relative"
        aria-label="Cart"
    >
        <UIcon name="i-lucide-shopping-cart" class="size-5" />

        <UBadge
            v-if="props.count > 0"
            color="primary"
            size="xs"
            class="absolute -right-1 -top-1"
        >
            {{ countLabel(props.count) }}
        </UBadge>
    </UButton>
</template>
