<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import { computed, reactive, ref } from 'vue'
import { router, usePage } from "@inertiajs/vue3";
import * as z from 'zod'

const props = defineProps({
    products: {
        type: Object,
        default: null,
    },
    addresses: {
        type: Object,
        default: null,
    }
})

const delivery = computed(() =>
    props.products?.data?.length ? 5 : 0
)

const page = usePage()
const isAuthenticated = ref(page.props.user ? true : false)

/*
|--------------------------------------------------------------------------
| Address state
|--------------------------------------------------------------------------
*/

const addressMode = ref(
    isAuthenticated.value && props.addresses.length > 0
        ? 'saved'
        : 'new'
)

const selectedAddress = ref(
    isAuthenticated.value && props.addresses.length > 0
        ? props.addresses[0].id
        : null
)

const saveAddress = ref(false)

const getInitialData = () => ({
    alias: '',
    name: '',
    address: '',
    city: '',
    postal_code: '',
    country: 'Poland',
    save_address: false
})

const addressForm = reactive(getInitialData())
const addressFormRef = ref()

const schema = computed(() => z.object({
    alias: saveAddress.value
        ? z.string().trim().min(1, 'Alias is required')
        : z.string().optional(),

    name: z.string().trim().min(1, 'Full name is required'),
    address: z.string().trim().min(1, 'Address is required'),
    city: z.string().trim().min(1, 'City is required'),
    postal_code: z.string().trim().min(1, 'Postal code is required'),
    country: z.string().trim().min(1, 'Country is required'),
}))

/*
|--------------------------------------------------------------------------
| Order summary
|--------------------------------------------------------------------------
*/

const subtotal = computed(() =>
    props.products?.data?.reduce(
        (total, item) =>
            total + item.product.price * item.quantity,
        0
    ) ?? 0
)

const total = computed(() =>
    subtotal.value + delivery.value
)

/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/


const submitCheckout = async () => {
    const payload = {
        address: null,
        items: props.products.data
    }

    if (addressMode.value === 'saved') {

        if (!selectedAddress.value) {
            return
        }

        payload.address = {
            type: 'saved',
            id: selectedAddress.value
        }
    } else {
        const valid = await addressFormRef.value?.validate()

        if (!valid) {
            return
        }

        payload.address = {
            type: 'new',
            ...addressForm,
            save_address: isAuthenticated.value
                ? saveAddress.value
                : false
        }
    }

    router.post(route('checkout.store'), payload)
    Object.assign(addressForm, getInitialData())
}
</script>

<template>
    <AppLayout>
        <div class="w-full pb-8">
            <!-- PAGE HEADER -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-highlighted">
                    Checkout
                </h1>

                <p class="mt-1 text-muted">
                    Enter your delivery details and review your order.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- ========================================================= -->
                <!-- LEFT: DELIVERY ADDRESS -->
                <!-- ========================================================= -->

                <div class="space-y-6 lg:col-span-2">
                    <UCard>
                        <template #header>
                            <div>
                                <h2 class="text-lg font-semibold text-highlighted">
                                    Delivery address
                                </h2>

                                <p class="text-sm text-muted">
                                    Choose where you want your order delivered.
                                </p>
                            </div>
                        </template>

                        <!-- ADDRESS OPTIONS -->
                        <div v-if="isAuthenticated && addresses.length > 0"
                            class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <!-- SAVED ADDRESS OPTION -->
                            <div class="cursor-pointer rounded-lg border p-4 transition" :class="addressMode === 'saved'
                                ? 'border-primary bg-primary/5'
                                : 'border-default hover:border-primary/50'
                                " @click="addressMode = 'saved'">
                                <div class="flex items-start gap-3">
                                    <URadio v-model="addressMode" value="saved" />

                                    <div>
                                        <p class="font-medium text-highlighted">
                                            Use saved address
                                        </p>

                                        <p class="mt-1 text-sm text-muted">
                                            Select one of your saved addresses.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- NEW ADDRESS OPTION -->
                            <div class="cursor-pointer rounded-lg border p-4 transition" :class="addressMode === 'new'
                                ? 'border-primary bg-primary/5'
                                : 'border-default hover:border-primary/50'
                                " @click="addressMode = 'new'">
                                <div class="flex items-start gap-3">
                                    <URadio v-model="addressMode" value="new" />

                                    <div>
                                        <p class="font-medium text-highlighted">
                                            Enter your address
                                        </p>

                                        <p class="mt-1 text-sm text-muted">
                                            Use a different delivery address.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ================================================= -->
                        <!-- SAVED ADDRESSES -->
                        <!-- ================================================= -->

                        <div v-if="
                            addressMode === 'saved' &&
                            isAuthenticated &&
                            addresses.length > 0
                        " class="mt-6 space-y-3">
                            <p class="text-sm font-medium text-highlighted">
                                Your saved addresses
                            </p>

                            <div v-for="address in addresses" :key="address.id"
                                class="cursor-pointer rounded-lg border p-4 transition" :class="selectedAddress === address.id
                                    ? 'border-primary bg-primary/5'
                                    : 'border-default hover:border-primary/50'
                                    " @click="selectedAddress = address.id">
                                <div class="flex items-start gap-3">
                                    <URadio v-model="selectedAddress" :value="address.id" />

                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-4">
                                            <p class="font-medium text-highlighted">
                                                {{ address.alias }}
                                            </p>
                                        </div>

                                        <p class="mt-1 text-sm text-muted">
                                            {{ address.name }}
                                        </p>

                                        <p class="mt-1 text-sm text-muted">
                                            {{ address.address }}
                                        </p>

                                        <p class="text-sm text-muted">
                                            {{ address.postal_code }}
                                            {{ address.city }}
                                        </p>

                                        <p class="text-sm text-muted">
                                            {{ address.country }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ================================================= -->
                        <!-- NEW ADDRESS FORM -->
                        <!-- ================================================= -->

                        <UForm v-if="addressMode === 'new'" ref="addressFormRef" :schema="schema" :state="addressForm">
                            <div class="mt-6 space-y-4">
                                <!-- NAME -->
                                <UFormField label="Full name" name="name" required>
                                    <UInput v-model="addressForm.name" placeholder="Your full name" class="w-full" />
                                </UFormField>

                                <!-- ADDRESS -->
                                <UFormField label="Address" name="address" required>
                                    <UInput v-model="addressForm.address" placeholder="Street and house number"
                                        class="w-full" />
                                </UFormField>

                                <!-- CITY + POSTAL -->
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <UFormField label="City" name="city" required>
                                        <UInput v-model="addressForm.city" placeholder="Warsaw" class="w-full" />
                                    </UFormField>

                                    <UFormField label="Postal code" name="postal_code" required>
                                        <UInput v-model="addressForm.postal_code" placeholder="00-001" class="w-full" />
                                    </UFormField>
                                </div>

                                <!-- COUNTRY -->
                                <UFormField label="Country" name="country" required>
                                    <UInput v-model="addressForm.country" placeholder="Poland" class="w-full" />
                                </UFormField>

                                <!-- SAVE ADDRESS -->
                                <UCheckbox v-if="isAuthenticated" v-model="saveAddress"
                                    label="Save this address for future orders" />

                                <!-- ALIAS -->
                                <UFormField v-if="saveAddress" name="alias" label="Alias" required>
                                    <UInput v-model="addressForm.alias" placeholder="Home, Work..." class="w-full" />
                                </UFormField>
                            </div>
                        </UForm>
                    </UCard>
                </div>

                <!-- ========================================================= -->
                <!-- RIGHT: ORDER SUMMARY -->
                <!-- ========================================================= -->

                <div class="lg:col-span-1">
                    <UCard class="lg:sticky lg:top-6">
                        <template #header>
                            <h2 class="text-lg font-semibold text-highlighted">
                                Order summary
                            </h2>
                        </template>

                        <div class="space-y-5">
                            <!-- PRODUCTS -->
                            <div class="space-y-4">
                                <div v-for="item in props.products?.data" :key="item.id" class="flex items-center gap-3">
                                    <UAvatar :src="item.product.image" :alt="item.product.name" size="lg"
                                        loading="lazy" />

                                    <div class="min-w-0 flex-1">
                                        <p class="truncate font-medium text-highlighted">
                                            {{ item.product.name }}
                                        </p>

                                        <p class="text-sm text-muted">
                                            Quantity: {{ item.quantity }}
                                        </p>
                                    </div>

                                    <p class="shrink-0 font-medium">
                                        ${{
                                            (
                                                item.product.price *
                                                item.quantity
                                            ).toFixed(2)
                                        }}
                                    </p>
                                </div>
                            </div>

                            <USeparator />

                            <!-- TOTALS -->
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-muted">
                                        Subtotal
                                    </span>

                                    <span class="font-medium">
                                        ${{ subtotal.toFixed(2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-muted">
                                        Delivery
                                    </span>

                                    <span class="font-medium">
                                        ${{ delivery.toFixed(2) }}
                                    </span>
                                </div>

                                <USeparator />

                                <div class="flex justify-between">
                                    <span class="font-semibold text-highlighted">
                                        Total
                                    </span>

                                    <span class="text-lg font-semibold text-highlighted">
                                        ${{ total.toFixed(2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- CONTINUE -->
                            <UButton block size="lg" icon="i-lucide-credit-card" label="Continue to payment" :disabled="addressMode === 'saved' &&
                                !selectedAddress
                                " @click.prevent="submitCheckout" />
                        </div>
                    </UCard>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
