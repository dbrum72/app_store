<template>
    <div class="content view">
        <aside>
            <AdminBar />
        </aside>
        <div>
            <router-view />
        </div>
    </div>
</template>

<script>
import AdminBar from '@/components/bars/admin-bar.vue';

export default {

    name: 'AdminIndex',

    components: { AdminBar },
}
</script>

<style>

</style>