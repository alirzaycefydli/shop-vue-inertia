<script setup>
const props = defineProps({
    href: {
        type: String,
        default: '/',
    },
});
</script>

<template>
    <Link
        :href="props.href"
        class="inline-flex items-center gap-3 rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-slate-950"
        aria-label="Shop home"
    >
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-primary dark:text-black text-white shadow-sm">
            <UIcon name="i-lucide-shopping-bag" class="size-5"/>
        </span>

        <span class="flex flex-col leading-tight">
            <span class="text-base font-semibold tracking-tight text-slate-950 dark:text-white">Shop</span>
            <span class="text-xs text-slate-500 dark:text-slate-400">Curated commerce</span>
        </span>
    </Link>
</template>
