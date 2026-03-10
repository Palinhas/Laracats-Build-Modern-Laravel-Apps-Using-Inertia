<script setup>
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline"
import {Link, router} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import {ref, watch} from "vue";
import debounce from "lodash/debounce";

let props = defineProps({
    users: Object,
    filters: Object,
    can: Object,
})

let search = ref(props.filters.search);
watch(search, debounce((value) => {
    router.get('/users', { search: value }, { preserveState: true, replace: true })
}, 300))

</script>

<template>
    <Head title="Users">
        <meta type="description"
              content="Information about the users of the application"
              head-key="description"/>
    </Head>
    <div class="flex justify-between mb-6">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold ml-5">Users</h1>
            <Link v-if="can.createUser" href="/users/create" class="btn btn-ghost ml-3">New User</Link>
        </div>

        <label class="input input-bordered input-sm w-full max-w-xs">
            <MagnifyingGlassIcon class="h-4 w-4 opacity-50" />
            <input v-model="search" type="search" required placeholder="Search" />
        </label>
    </div>

    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mt-5">
        <table class="table">
            <tbody>
            <!-- row 1 -->
            <tr v-for="user in users.data" :key="user.id">
                <th>{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td><Link v-if="user.can.updateUser" :href="`/users/${user.id}/edit`" class="btn btn-ghost">Edit</Link></td>
            </tr>
            </tbody>
        </table>
    </div>

    <Pagination :links="users.links" class="mt-6 join"/>

</template>

<style scoped>

</style>
