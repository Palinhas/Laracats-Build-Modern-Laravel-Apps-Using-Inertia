<script setup>
import NavLink from "@/Components/NavLink.vue";
</script>

<template>
    <nav class=" p-4 text-black font-bold mb-4">
        <ul class="flex space-x-6">
            <li><NavLink :active="$page.component === 'Home'"
                          href="/">Home</NavLink></li>
            <li><NavLink :active="$page.component === 'Users'"
                          href="/users">Users</NavLink></li>
            <li><NavLink :active="$page.component === 'Settings'"
                          href="/settings">Settings</NavLink></li>
            <li><NavLink method="post" href="/logout">Logout</NavLink></li>
        </ul>
    </nav>

</template>

<style scoped>
/* Apenas CSS aqui */
</style>
