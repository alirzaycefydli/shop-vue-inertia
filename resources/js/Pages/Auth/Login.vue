<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import ErrorMessages from "../../Components/UI/ErrorMessages.vue";

const props = defineProps({
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
                <ErrorMessages :errors="props.errors" />
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
