<template>
    <div class="box-price">
        <div class="caption">{{ title }}</div>

        <div class="value">{{ toCurrency(value ? value : 0) }}</div>
    </div>
</template>

<script>
import AbstractMixin from '@/mixins/AbstractMixin';
export default {

    name: 'BoxPrice',

    props: [
        'title',
        'value'
    ],

    mixins: [AbstractMixin]

}
</script>

<style>


</style>