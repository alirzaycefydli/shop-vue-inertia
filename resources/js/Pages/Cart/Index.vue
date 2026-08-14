<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import {computed} from 'vue'
import {router, usePage} from "@inertiajs/vue3";

const props = defineProps({
    products: {
        type: Object,
        required: true,
    }
})

const delivery = 5

const subtotal = computed(() =>
    props.products.data.reduce(
        (total, item) => total + item.product.price * item.quantity,
        0
    )
)

const total = computed(() => subtotal.value + delivery)

const increaseQuantity = (item) => {
    if (item.product_quantity > item.quantity) {
        item.quantity++

        updateQuantity(item)
    }
}

const decreaseQuantity = (item) => {
    if (item.quantity > 1) {
        item.quantity--

        updateQuantity(item)
    }
}

const updateQuantity = (item) => {
    router.patch(route('cart.update', item), {quantity: item.quantity})
}

const page = usePage()
const messages = computed(() => page.props.messages)
const toast = useToast()

const removeItem = (id) => {
    if (window.confirm(`Are you sure you want to remove this item?`)) {
        router.delete(route('cart.destroy', id), {
            onFinish: () => {
                toast.add({
                    color: messages.value.type,
                    title: messages.value.message,
                    icon: 'i-lucide-shopping-cart',
                })
            }
        })
    }
}
</script>

<template>
    <AppLayout title="Cart">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <UCard>
                    <template #header>
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold">
                                    Shopping Cart
                                </h2>

                                <p class="text-sm text-muted">
                                    {{ props.products.data.length }} items
                                </p>
                            </div>
                        </div>
                    </template>

                    <div class="divide-y divide-default">
                        <div
                            v-for="item in props.products.data"
                            :key="item.id"
                            class="flex gap-4 py-5 first:pt-0 last:pb-0"
                        >
                            <UAvatar
                                :src="item.product.image"
                                :alt="item.product.name"
                                size="3xl"
                                class="shrink-0"
                            />
                            <div class="flex min-w-0 flex-1 items-center justify-between gap-4">
                                <Link
                                    :href="route('products.show', item.product.slug)"
                                    target="_blank"
                                >
                                    <div class="min-w-0">
                                        <h3 class="truncate font-medium text-highlighted">
                                            {{ item.product.name }}
                                        </h3>

                                        <p class="mt-1 text-sm text-muted">
                                            ${{ item.product.price.toFixed(2) }}
                                        </p>
                                    </div>
                                </Link>

                                <div class="flex shrink-0 items-center gap-4">
                                    <span class="font-semibold">
                                            ${{ (item.product.price * item.quantity).toFixed(2) }}
                                        </span>
                                    <div class="flex items-center gap-2">
                                        <UButton
                                            icon="i-lucide-minus"
                                            color="neutral"
                                            variant="outline"
                                            size="sm"
                                            :disabled="item.quantity <= 1"
                                            @click="decreaseQuantity(item)"
                                        />
                                        <span class="w-8 text-center font-medium">
                                            {{ item.quantity }}
                                        </span>
                                        <UButton
                                            icon="i-lucide-plus"
                                            color="neutral"
                                            variant="outline"
                                            size="sm"
                                            :disabled="item.quantity >= item.product_quantity"
                                            @click="increaseQuantity(item)"
                                        />
                                    </div>
                                    <div class="flex items-center justify-between gap-4 sm:justify-end">
                                        <UButton
                                            icon="i-lucide-trash-2"
                                            color="error"
                                            variant="ghost"
                                            size="sm"
                                            aria-label="Remove product"
                                            @click="removeItem(item.id)"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template #footer>
                        <div class="flex justify-between">
                            <Link :href="route('products.index')" class="flex justify-between gap-2">
                                <UIcon name="i-lucide-arrow-left" class="size-5"/>
                                <span>
                                    Continue shopping
                                </span>
                            </Link>
                        </div>
                    </template>
                </UCard>
            </div>

            <div>
                <UCard class="lg:sticky lg:top-4">
                    <template #header>
                        <h2 class="text-xl font-semibold">
                            Order Summary
                        </h2>
                    </template>

                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                        <span class="text-muted">
                            Subtotal
                        </span>

                            <span>
                            ${{ subtotal.toFixed(2) }}
                        </span>
                        </div>

                        <div class="flex justify-between text-sm">
                        <span class="text-muted">
                            Delivery
                        </span>

                            <span>
                            ${{ delivery.toFixed(2) }}
                        </span>
                        </div>

                        <USeparator/>

                        <div class="flex items-center justify-between">
                        <span class="font-semibold">
                            Total
                        </span>

                            <span class="text-xl font-bold">
                            ${{ total.toFixed(2) }}
                        </span>
                        </div>
                    </div>

                    <template #footer>
                        <UButton
                            block
                            size="lg"
                            trailing-icon="i-lucide-arrow-right"
                        >
                            Continue to delivery
                        </UButton>
                    </template>
                </UCard>
            </div>
        </div>
    </AppLayout>
</template>
