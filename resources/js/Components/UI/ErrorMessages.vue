<script setup>
defineProps({
    errors: Object,
});
</script>

<template>
    <div class="mb-4" v-if="Object.keys(errors).length">
        <ul class="ml-4 list-disc list-inside">
            <li
                v-for="(error, index) in errors"
                :key="index"
                class="text-sm text-red-500"
            >
                {{ error[0] }}
            </li>
        </ul>
    </div>
</template>
