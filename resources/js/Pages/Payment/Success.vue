<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";

defineProps(['orderNumber'])

</script>
<template>
   <AppLayout>
    <div class="flex min-h-[60vh] items-center justify-center px-4 py-12">
        <UCard class="w-full max-w-md text-center">
            <div class="flex flex-col items-center gap-4">
                <UIcon
                    name="i-lucide-circle-check"
                    class="size-16 text-success"
                />

                <h1 class="text-2xl font-semibold">
                    Thank you for your order!
                </h1>

                <p class="text-muted">
                    Your order has been placed successfully.
                    We'll take care of the rest.
                </p>

                <div class="w-full rounded-lg bg-muted p-4">
                    <p class="text-sm text-muted">
                        Your order number
                    </p>

                    <p class="mt-1 text-lg font-semibold">
                        {{ orderNumber }}
                    </p>
                </div>

                <UButton :to="route('products.index')" block>
                    Continue shopping
                </UButton>
            </div>
        </UCard>
    </div>
   </AppLayout>
</template>
