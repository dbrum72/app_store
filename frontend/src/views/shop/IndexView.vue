<template>
    <div>
        <ShopBar />
        <div>
            <router-view />
        </div>
    </div>
</template>

<script>
import ShopBar from '@/components/shop/ShopBar.vue';

export default {

    name: 'IndexView',

    components: { ShopBar },
}
</script>

<style></style>