<script setup>
import defaultProductImage from '@/../images/default-product-img.png'

const props = defineProps({
    items: {
        type: Array,
        default: () => [defaultProductImage]
    }
})
</script>

<template>
    <UCarousel v-slot="{ item }" arrows :items="items" class="w-full max-w-xs mx-auto">
        <img
            :src="item"
            alt=""
            width=""
            class="rounded-lg object-contain w-full h-full"
            loading="lazy"
        >
    </UCarousel>
</template>

