<script setup>
import { useForm, Head } from "@inertiajs/vue3";

const form = useForm({
    name: '',
    email: '',
    password: '',
})

const submit = () => {
    form.post('/users', {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Users - Create">
        <meta type="description"
              content="Create a new user for the application"
              head-key="description"/>
    </Head>
    <h1 class="text-2xl font-bold ml-5">Create User</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto">
        <div class="mb-6">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">What is your name?</legend>
                <input v-model="form.name" type="text" class="input w-full" :class="{ 'input-error': form.errors.name }" placeholder="Type here" />
                <p v-if="form.errors.name" class="fieldset-label text-error">{{ form.errors.name }}</p>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">What is your email?</legend>
                <input v-model="form.email" type="email" class="input w-full" :class="{ 'input-error': form.errors.email }" placeholder="Type here" />
                <p v-if="form.errors.email" class="fieldset-label text-error">{{ form.errors.email }}</p>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">What is your password?</legend>
                <input v-model="form.password" type="password" class="input w-full" :class="{ 'input-error': form.errors.password }" placeholder="Type here" />
                <p v-if="form.errors.password" class="fieldset-label text-error">{{ form.errors.password }}</p>
            </fieldset>
        </div>
        <div class="mb-6">
            <button class="btn btn-neutral btn-block" :disabled="form.processing">
                <span v-if="form.processing" class="loading loading-spinner loading-sm"></span>
                Create
            </button>
        </div>
    </form>
</template>

