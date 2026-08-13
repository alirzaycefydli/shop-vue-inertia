<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import {computed, ref, watch} from "vue";
import {router, usePage} from "@inertiajs/vue3";

const props = defineProps({
    products: {
        type: Object,
        required: true
    }
})

const data = computed(() => props.products)
const pagination = ref({
    pageIndex: props.products.current_page,
    pageSize: props.products.per_page,
})
const columns = [
    {
        accessorKey: 'product',
        header: 'Products'
    },
    {
        accessorKey: 'action',
        header: 'Actions',
        id: 'action',
        meta: {
            class: {
                th: 'w-24',
                td: 'w-24',
            },
        },
    }
]

const onSubmitDelete = (slug) => {
    if (window.confirm("Are you sure?")) {
        router.delete(route('wishlists.destroy', slug), {
            onSuccess: () => {
                reload(data.value.current_page)
            },
        },)
    }
}

const onSubmitAddToCart = (slug) => {
    router.post(route('cart.store', slug), {
        onSuccess: () => {
            reload(data.value.current_page)
        },
    },)
}

watch(
    () => data.value.current_page,
    (page) => {
        reload(page)
    }
)

const pageProps = usePage()
const messages = computed(() => pageProps.props.messages)
const toast = useToast()

const reload = (page) => {
    if (page > props.products.last_page)
        page = props.products.last_page
    router.get(route('wishlists.index'), {page: page})
}

watch(
    () => messages.value,
    (messages) => {
        toast.add({
            color: messages.type,
            title: messages.message,
            icon: 'i-lucide-shopping-cart',
        })
    }
)
</script>

<template>
    <AppLayout>
        <div class="w-full space-y-4 pb-4">
            <UTable :data="data.data" :columns="columns" v-model:pagination="pagination" class="flex-1">
                <template #product-cell="{ row }">
                    <div class="flex items-center gap-3">
                        <UAvatar
                            :src="row.original.data.image"
                            size="lg"
                            loading="lazy"
                            :alt="row.original.data.slug"
                        />
                        <div>
                            <p class="font-medium text-highlighted">
                                {{ row.original.data.name }}
                            </p>
                            <p>
                                ${{ row.original.data.price }}
                            </p>
                        </div>
                    </div>
                </template>
                <template #action-cell="{ row }" class="gap-1">
                    <UButton
                        icon="i-lucide-shopping-cart"
                        color="neutral"
                        variant="ghost"
                        aria-label="Actions"
                        @click.prevent="onSubmitAddToCart(row.original.data.slug)"
                    />
                    <UButton
                        icon="i-lucide-trash-2"
                        color="neutral"
                        variant="ghost"
                        aria-label="Actions"
                        @click.prevent="onSubmitDelete(row.original.data.slug)"
                    />
                </template>
            </UTable>
            <div class="flex justify-start border-t border-default pt-4 px-4">
                <UPagination
                    v-model:page="data.current_page"
                    :total="data.total"
                    :items-per-page="data.per_page"
                    :sibling-count="3"
                />
            </div>
        </div>
    </AppLayout>
</template>
