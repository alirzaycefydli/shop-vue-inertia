<script setup>
import {computed, ref} from 'vue';
import Logo from './Logo.vue';
import SearchBar from './SearchBar.vue';
import WishlistButton from './WishlistButton.vue';
import CartButton from './CartButton.vue';
import UserMenu from './UserMenu.vue';
import Navigation from './Navigation.vue';
import MobileMenu from './MobileMenu.vue';
import ThemeToggle from '@/Layouts/ThemeToggle.vue';
import {usePage} from "@inertiajs/vue3";

const page= usePage()
const user = computed(() => page.props.user)

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        required: true,
    },
    cartCount: {
        type: Number,
        default: 0,
    },
    wishlistCount: {
        type: Number,
        default: 0,
    },
});

const mobileMenuOpen = ref(false);
</script>

<template>
    <header
        class="sticky top-0 z-100 border-b border-slate-200 bg-white/90 backdrop-blur transition-colors dark:border-slate-800 dark:bg-slate-950/90">
        <div
            class="relative z-120 mx-auto max-w-7xl bg-white/90 px-4 backdrop-blur dark:bg-slate-950/90 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-4 lg:gap-6 bg">
                <Logo :href="route('home')"/>

                <div class="hidden min-w-0 flex-1 lg:block">
                    <SearchBar
                        @search="$emit('search', $event)"
                    />
                </div>

                <div class="ml-auto hidden items-center gap-2 lg:flex">
                    <ThemeToggle/>
                    <WishlistButton v-if="user" :count="wishlistCount ?? 0" :href="route('wishlists.index')"/>
                    <CartButton :count="cartCount ?? 0"/>
                    <UserMenu/>
                </div>

                <div class="ml-auto flex items-center gap-2 lg:hidden">
                    <ThemeToggle/>

                    <UButton
                        as="Link"
                        type="button"
                        color="neutral"
                        variant="outline"
                        size="lg"
                        aria-label="Open menu"
                        aria-controls="mobile-menu"
                        :aria-expanded="mobileMenuOpen"
                        @click="mobileMenuOpen = true"
                    >
                        <UIcon name="i-lucide-menu" class="size-5"/>
                        <span>Menu</span>
                    </UButton>
                </div>
            </div>
        </div>

        <div class="relative z-110 hidden lg:block">
            <Navigation :categories="categories" :items="items"/>
        </div>

        <MobileMenu
            :open="mobileMenuOpen"
            :categories="categories"
            :items="items"
            :cart-count="cartCount ?? 0"
            :wishlist-count="wishlistCount ?? 0"
            @close="mobileMenuOpen = false"
        />
    </header>
</template>
