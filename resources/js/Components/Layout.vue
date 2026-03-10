<script setup>
import { computed } from 'vue';
import {Head, usePage} from '@inertiajs/vue3';
import Navbar from "@/Components/Navbar.vue";

const page = usePage();
const username = computed(() => page.props.auth.user.username);
</script>

<template>
    <Head>
        <title>My App - Users</title>
        <meta type="description"
              content="This is a sample application built with Laravel and Inertia.js"
              head-key="description"/>
    </Head>
    <section class="p-6 bg-gray-200/60">
        <header class="flex justify-between">
            <div class="flex items-center">
                <h1 class="text-lg font-bold mt-5 ml-5">My App</h1>
                <p class="mt-5 ml-5" v-if="username">Welcome back, {{ username }}</p>
            </div>
                <Navbar/>
        </header>
    </section>
    <section class="p-6 ">
        <div class="max-w-3xl mx-auto ">
            <slot />
        </div>
    </section>
</template>

