<script setup>
import {computed, onBeforeUnmount, onMounted, ref} from 'vue';
import {router, usePage} from "@inertiajs/vue3";


const page = usePage()
const user = computed(() => page.props.user);

const isOpen = ref(false);
const menuRef = ref(null);

const initials = computed(() => {
    if (!user?.value.name) {
        return 'U';
    }

    return user?.value.name
        .split(' ')
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase() ?? '')
        .join('');
});

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

const onSubmit = (param) => {
    router.get(route(param))
}

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
    <div v-if="user" ref="menuRef" class="relative z-300">
        <button
            type="button"
            class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-left text-sm text-slate-700 shadow-sm transition hover:border-slate-300 hover:text-slate-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-slate-700 dark:hover:text-white dark:focus-visible:ring-offset-slate-950"
            :aria-expanded="isOpen"
            aria-haspopup="menu"
            @click.stop="toggle"
        >
            <span
                class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-primary text-sm font-semibold text-white dark:text-black">
                {{ initials }}
            </span>

            <span class="hidden min-w-0 flex-col leading-tight lg:flex">
                <span class="truncate font-medium text-slate-950 dark:text-white">{{ user.name }}</span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Account</span>
            </span>

            <UIcon
                name="i-lucide-chevron-down"
                class="size-4 text-slate-400 transition"
                :class="{ 'rotate-180': isOpen }"
            />
        </button>

        <div
            v-if="isOpen"
            class="absolute right-0 top-full z-300 mt-3 w-64 rounded-md border border-slate-200 bg-white p-2 shadow-2xl transition-colors dark:border-slate-800 dark:bg-slate-900"
            role="menu"
        >
            <div class="px-3 py-3">
                <p class="text-sm font-semibold text-slate-950 dark:text-white">{{ user.name }}name</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Signed in</p>
            </div>

            <div class="space-y-1">
                <Link
                    href="/account"
                    class="flex items-center gap-3 rounded-2xl px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white dark:focus-visible:bg-slate-800"
                    role="menuitem"
                    @click="close"
                >
                    <UIcon name="i-lucide-user" class="size-4"/>
                    My Account
                </Link>

                <Link
                    href="/orders"
                    class="flex items-center gap-3 rounded-2xl px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white dark:focus-visible:bg-slate-800"
                    role="menuitem"
                    @click="close"
                >
                    <UIcon name="i-lucide-package" class="size-4"/>
                    Orders
                </Link>

                <Link
                    href="/wishlist"
                    class="flex items-center gap-3 rounded-2xl px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white dark:focus-visible:bg-slate-800"
                    role="menuitem"
                    @click="close"
                >
                    <UIcon name="i-lucide-heart" class="size-4"/>
                    Wishlist
                </Link>

                <Link
                    href="/settings"
                    class="flex items-center gap-3 rounded-2xl px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white dark:focus-visible:bg-slate-800"
                    role="menuitem"
                    @click="close"
                >
                    <UIcon name="i-lucide-settings" class="size-4"/>
                    Settings
                </Link>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex w-full items-center gap-3 rounded-2xl px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white dark:focus-visible:bg-slate-800"
                    role="menuitem"
                    @click="close"
                >
                    <UIcon name="i-lucide-log-out" class="size-4"/>
                    Logout
                </Link>
            </div>
        </div>
    </div>

    <div v-else class="flex items-center gap-2">
        <UButton
            as="Link"
            color="neutral"
            variant="outline"
            class="cursor-default"
            @click="onSubmit('login')"
        >
            Login
        </UButton>

        <UButton
            as="Link"
            color="primary"
            variant="solid"
            class="cursor-default"
            @click="onSubmit('register')"
        >
            Register
        </UButton>
    </div>
</template>
