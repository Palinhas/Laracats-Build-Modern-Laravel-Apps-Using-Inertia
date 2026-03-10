<script setup>
import {Head, useForm} from "@inertiajs/vue3";

defineOptions({ layout: null })

const form = useForm({
    email: '',
    password: '',
})

const submit = () => {
    form.post('/login', {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Login">
        <meta type="description"
              content="Login to your account to access the application"
              head-key="description"/>

    </Head>
    <main class="grid place-items-center min-h-screen">

       <section class="max-w-md mx-auto p-8">
           <h1 class="text-2xl font-bold mb-5 ml-5 mt-5">Login</h1>
           <form @submit.prevent="submit" class="max-w-md mx-auto">
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
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

                <div class="mt-3 mb-3">
                    <button class="btn btn-neutral btn-block" :disabled="form.processing">
                        <span v-if="form.processing" class="loading loading-spinner loading-sm"></span>
                        Login
                    </button>
                </div>
            </fieldset>
           </form>
       </section>
    </main>
</template>

<style scoped>

</style>
