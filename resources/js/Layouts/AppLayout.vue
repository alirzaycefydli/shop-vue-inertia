<script setup>
import {computed} from 'vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import Header from '@/Components/Layout/Header.vue';
import Footer from '@/Components/Layout/Footer.vue';
import {
    footerLinkGroups,
    navigationItems,
    socialLinks,
} from '@/composables/useEcommerceData';

const props = defineProps({
    title: {
        type: String,
        default: undefined,
    },
    cartCount: {
        type: Number,
        default: 3,
    },
    wishlistCount: {
        type: Number,
        default: 7,
    },
});

const page = usePage()
const categories = computed(() => page.props.navigation_categories.data)

const handleSearch = (value) => {
    if (value.length > 0) {
        router.get(
            route('products.index'),
            {
                search: value,
                page: 1,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }
}

// Replace the imported mock values above with Laravel shared props in HandleInertiaRequests.
const pageTitle = computed(() => (props.title ? `${props.title} | Shop` : 'Shop'));
</script>

<template>
    <UApp>
        <Head :title="pageTitle"/>

        <div
            class="flex min-h-screen flex-col bg-white text-slate-950 transition-colors dark:bg-slate-950 dark:text-slate-100">
            <Header
                :categories="categories"
                :items="navigationItems"
                :cart-count="cartCount"
                :wishlist-count="wishlistCount"
                @search="handleSearch"
            />
            <main class="flex-1 bg-slate-50 transition-colors dark:bg-slate-950">
                <div class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
                    <slot/>
                </div>
            </main>

            <Footer :link-groups="footerLinkGroups" :socials="socialLinks"/>
        </div>
    </UApp>
</template>
