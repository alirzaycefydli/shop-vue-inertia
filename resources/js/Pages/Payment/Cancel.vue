<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";

</script>
<template>
   <AppLayout>
    <div class="flex min-h-[60vh] items-center justify-center px-4 py-12">
        <UCard class="w-full max-w-md text-center">
            <div class="flex flex-col items-center gap-4">
                <UIcon
                    name="i-lucide-circle-x"
                    class="size-16 text-warning"
                />

                <h1 class="text-2xl font-semibold">
                    Order cancelled
                </h1>

                <p class="text-muted">
                    Your checkout was cancelled.
                    No order was completed. You can return to your
                    cart and try again whenever you're ready.
                </p>

                <UButton :to="route('cart.index')" block>
                    Return to cart
                </UButton>
            </div>
        </UCard>
    </div>
   </AppLayout>
</template>