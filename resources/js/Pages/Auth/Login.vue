<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import {ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";

defineProps({
    errors: {
        type: Object
    }
})

const fields = ref([
    {
        name: 'email',
        type: 'text',
        label: 'Email',
        placeholder: 'your_email@example.com'
    },
    {
        name: 'password',
        type: 'password',
        label: 'Password',
        placeholder: 'Your password'
    },
    {
        name: 'remember',
        type: 'checkbox',
        label: 'Remember me',
    },
])

const page = usePage()

const loading = ref(false)

const onSubmit = (data) => {
    loading.value = true

    router.post(route('login.store'), data.data, {
        onFinish: () => {
            loading.value = false
        }
    })
}
</script>

<template>
    <AppLayout title="Login">
        <div class="flex flex-col items-center justify-center gap-4 p-4">
            <UPageCard class="w-full max-w-md">
                <UAlert
                    color="error"
                    :title="fields.email"
                />
                <UAuthForm
                    class="max-w-md"
                    title="Login to your account"
                    description="Enter your credentials to login your account."
                    :fields="fields"
                    :submit="{
                    label: 'Login',
                    loading,
                }"
                    @submit.prevent="onSubmit"
                />
            </UPageCard>
        </div>
    </AppLayout>

</template>
