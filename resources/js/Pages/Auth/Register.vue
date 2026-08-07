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
        name: 'name',
        type: 'text',
        label: 'Name',
        placeholder: 'Your full name.'
    },
    {
        name: 'email',
        type: 'email',
        label: 'Email',
        placeholder: 'your_email@example.com'
    },
    {
        name: 'password',
        type: 'password',
        label: 'Password',
        placeholder: 'Strong password'
    },
    {
        name: 'password_confirmation',
        type: 'password',
        label: 'Confirm your password',
        placeholder: 'Repeat your strong password'
    },
])
const loading = ref(false)

const onSubmit = (data) => {
    loading.value = true

    router.post(route('register.store'), data.data, {
        onFinish: () => {
            loading.value = false
        }
    })
}
</script>

<template>
    <AppLayout title="Register">
        <div class="flex flex-col items-center justify-center gap-4 p-4">
            <UPageCard class="w-full max-w-md">
                <ErrorMessages :errors="props.errors"/>
                <UAuthForm
                    class="max-w-md"
                    title="Register an account"
                    description="Enter your credentials to create your account."
                    :fields="fields"
                    :submit="{
                    label: 'Register',
                    loading,
                }"
                    @submit.prevent="onSubmit"
                />
            </UPageCard>
        </div>
    </AppLayout>

</template>
