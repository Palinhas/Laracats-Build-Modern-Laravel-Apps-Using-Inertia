<script setup>
import {Link} from "@inertiajs/vue3";
defineProps({
    links: Array,
})
</script>

<template>
    <div :class="$attrs.class">
        <Link
            v-for="link in links"
            :key="link.label"
            v-html="link.label"
            :href="link.url ?? ''"
            preserve-scroll
            :class="[
                'join-item btn btn-sm',
                link.active ? 'btn-active' : '',
                !link.url ? 'btn-disabled' : ''
            ]"
        />
    </div>
</template>

<style scoped>

</style>
