<script setup>
import { onBeforeUnmount, watch } from 'vue';
import SearchBar from './SearchBar.vue';

const props = defineProps({
    open: {
        type: Boolean,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        required: true,
    },
    user: {
        type: Object,
        default: null,
    },
    cartCount: {
        type: Number,
        required: true,
    },
    wishlistCount: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(['close']);

const handleKeydown = (event) => {
    if (event.key === 'Escape') {
        emit('close');
    }
};

watch(
    () => props.open,
    (open) => {
        if (typeof window === 'undefined' || typeof document === 'undefined') {
            return;
        }

        document.body.classList.toggle('overflow-hidden', open);

        if (open) {
            window.addEventListener('keydown', handleKeydown);
        } else {
            window.removeEventListener('keydown', handleKeydown);
        }
    },
    { immediate: true },
);

onBeforeUnmount(() => {
    if (typeof document !== 'undefined') {
        document.body.classList.remove('overflow-hidden');
    }

    if (typeof window !== 'undefined') {
        window.removeEventListener('keydown', handleKeydown);
    }
});

const countLabel = (count) => (count > 99 ? '99+' : String(count));
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="open" class="fixed inset-0 z-50 lg:hidden">
                <button
                    type="button"
                    class="absolute inset-0 bg-slate-950/40 dark:bg-slate-950/70"
                    aria-label="Close menu overlay"
                    @click="emit('close')"
                />

                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="translate-x-full"
                    enter-to-class="translate-x-0"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="translate-x-0"
                    leave-to-class="translate-x-full"
                >
                    <aside
                        id="mobile-menu"
                        role="dialog"
                        aria-modal="true"
                        class="absolute right-0 top-0 flex h-full w-full max-w-sm flex-col overflow-hidden bg-white shadow-2xl transition-colors dark:bg-slate-950"
                        aria-label="Mobile menu"
                    >
                        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-slate-800">
                            <p class="text-sm font-semibold text-slate-950 dark:text-white">Menu</p>

                            <UButton
                                type="button"
                                color="neutral"
                                variant="ghost"
                                size="md"
                                icon="i-lucide-x"
                                aria-label="Close menu"
                                @click="emit('close')"
                            >
                                Close
                            </UButton>
                        </div>

                        <div class="flex-1 space-y-6 overflow-y-auto px-4 py-5">
                            <SearchBar placeholder="Search products" />

                            <section class="space-y-3">
                                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                    Browse
                                </h2>

                                <div class="space-y-1">
                                    <Link
                                        v-for="item in items"
                                        :key="item.href"
                                        :href="item.href"
                                        class="flex items-center justify-between rounded-2xl px-3 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white dark:focus-visible:bg-slate-900"
                                        @click="emit('close')"
                                    >
                                        <span>{{ item.label }}</span>
                                        <UIcon name="i-lucide-chevron-right" class="size-4 text-slate-400" />
                                    </Link>
                                </div>
                            </section>

                            <section class="space-y-3">
                                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                    Categories
                                </h2>

                                <div class="space-y-1">
                                    <Link
                                        v-for="category in categories"
                                        :key="category.href"
                                        :href="category.href"
                                        class="block rounded-2xl px-3 py-3 transition hover:bg-slate-50 focus:outline-none focus-visible:bg-slate-50 dark:hover:bg-slate-900 dark:focus-visible:bg-slate-900"
                                        @click="emit('close')"
                                    >
                                        <span class="block text-sm font-medium text-slate-950 dark:text-white">
                                            {{ category.label }}
                                        </span>
                                        <span class="block text-sm text-slate-500 dark:text-slate-400">
                                            {{ category.description }}
                                        </span>
                                    </Link>
                                </div>
                            </section>

                            <section class="grid grid-cols-2 gap-3">
                                <UButton
                                    as="Link"
                                    to="/wishlist"
                                    color="neutral"
                                    variant="outline"
                                    class="justify-between"
                                    @click="emit('close')"
                                >
                                    <span class="inline-flex items-center gap-2">
                                        <UIcon name="i-lucide-heart" class="size-4" />
                                        Wishlist
                                    </span>

                                    <UBadge v-if="wishlistCount > 0" color="error" size="xs">
                                        {{ countLabel(wishlistCount) }}
                                    </UBadge>
                                </UButton>

                                <UButton
                                    as="Link"
                                    to="/cart"
                                    color="neutral"
                                    variant="outline"
                                    class="justify-between"
                                    @click="emit('close')"
                                >
                                    <span class="inline-flex items-center gap-2">
                                        <UIcon name="i-lucide-shopping-cart" class="size-4" />
                                        Cart
                                    </span>

                                    <UBadge v-if="cartCount > 0" color="primary" size="xs">
                                        {{ countLabel(cartCount) }}
                                    </UBadge>
                                </UButton>
                            </section>

                            <section class="space-y-3">
                                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                    Account
                                </h2>

                                <div v-if="user" class="space-y-1">
                                    <Link
                                        href="/account"
                                        class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white dark:focus-visible:bg-slate-900"
                                        @click="emit('close')"
                                    >
                                        <UIcon name="i-lucide-user" class="size-4" />
                                        My Account
                                    </Link>

                                    <Link
                                        href="/orders"
                                        class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white dark:focus-visible:bg-slate-900"
                                        @click="emit('close')"
                                    >
                                        <UIcon name="i-lucide-package" class="size-4" />
                                        Orders
                                    </Link>

                                    <Link
                                        href="/settings"
                                        class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white dark:focus-visible:bg-slate-900"
                                        @click="emit('close')"
                                    >
                                        <UIcon name="i-lucide-settings" class="size-4" />
                                        Settings
                                    </Link>

                                    <Link
                                        href="/logout"
                                        method="post"
                                        as="button"
                                        class="flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white dark:focus-visible:bg-slate-900"
                                        @click="emit('close')"
                                    >
                                        <UIcon name="i-lucide-log-out" class="size-4" />
                                        Logout
                                    </Link>
                                </div>

                                <div v-else class="grid grid-cols-2 gap-3">
                                    <UButton
                                        as="Link"
                                        to="/login"
                                        color="neutral"
                                        variant="outline"
                                        class="justify-center"
                                        @click="emit('close')"
                                    >
                                        Login
                                    </UButton>

                                    <UButton
                                        as="Link"
                                        to="/register"
                                        color="primary"
                                        variant="solid"
                                        class="justify-center"
                                        @click="emit('close')"
                                    >
                                        Register
                                    </UButton>
                                </div>
                            </section>
                        </div>
                    </aside>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
