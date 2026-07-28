<script setup>

defineProps({
    linkGroups: {
        type: Array,
        required: true,
    },
    socials: {
        type: Array,
        required: true,
    },
});

const socialIcon = (label) => {
    const icons = {
        Instagram: 'i-lucide-instagram',
        Facebook: 'i-lucide-facebook',
        X: 'i-lucide-twitter',
        YouTube: 'i-lucide-youtube',
    };

    return icons[label] ?? 'i-lucide-link';
};
</script>

<template>
    <footer class="border-t border-slate-200 bg-white transition-colors dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.5fr_1fr_1fr_1.2fr]">
                <section class="space-y-4">
                    <div>
                        <p class="text-lg font-semibold text-slate-950 dark:text-white">Shop</p>
                        <p class="mt-2 max-w-md text-sm leading-6 text-slate-600 dark:text-slate-400">
                            A clean storefront shell for product discovery, merchandising, and repeat purchases.
                        </p>
                    </div>

                    <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                        <li class="flex items-center gap-2">
                            <UIcon name="i-lucide-map-pin" class="size-4" />
                            Warsaw, Poland
                        </li>
                        <li class="flex items-center gap-2">
                            <UIcon name="i-lucide-phone" class="size-4" />
                            +48 555 010 123
                        </li>
                        <li class="flex items-center gap-2">
                            <UIcon name="i-lucide-mail" class="size-4" />
                            support@shop.test
                        </li>
                    </ul>
                </section>

                <section
                    v-for="group in linkGroups"
                    :key="group.title"
                    class="space-y-4"
                >
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-950 dark:text-white">{{ group.title }}</h2>
                    <ul class="space-y-3">
                        <li v-for="link in group.links" :key="link.href">
                            <Link
                                :href="link.href"
                                class="text-sm text-slate-600 transition hover:text-slate-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 dark:text-slate-400 dark:hover:text-white"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </section>

                <section class="space-y-4">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-950 dark:text-white">Newsletter</h2>
                    <p class="text-sm leading-6 text-slate-600 dark:text-slate-400">
                        Get updates about new arrivals, offers, and store announcements.
                    </p>

                    <form class="space-y-3" @submit.prevent>
                        <label class="sr-only" for="footer-newsletter-email">Email address</label>

                        <UInput
                            id="footer-newsletter-email"
                            type="email"
                            name="email"
                            autocomplete="email"
                            placeholder="Email address"
                            icon="i-lucide-mail"
                            size="xl"
                        />

                        <UButton type="submit" color="primary" size="lg" trailing-icon="i-lucide-arrow-right">
                            Subscribe
                        </UButton>
                    </form>

                    <div class="flex flex-wrap gap-2">
                        <UButton
                            v-for="social in socials"
                            :key="social.href"
                            :href="social.href"
                            as="a"
                            color="neutral"
                            variant="outline"
                            target="_blank"
                            rel="noreferrer"
                            :icon="socialIcon(social.label)"
                        >
                            {{ social.label }}
                        </UButton>
                    </div>
                </section>
            </div>

            <div class="mt-12 flex flex-col gap-4 border-t border-slate-200 pt-6 text-sm text-slate-500 dark:border-slate-800 dark:text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <p>Copyright © 2026 Shop. All rights reserved.</p>
                <p>Built for Laravel, Inertia.js, Vue 3, Tailwind CSS v4, and Nuxt UI.</p>
            </div>
        </div>
    </footer>
</template>
