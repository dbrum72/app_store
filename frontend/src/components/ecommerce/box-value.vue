<template>
    <div class="box-price">
        <div class="caption">{{ title }}</div>

        <div class="value">{{ value ? value : 0 }}</div>
    </div>
</template>

<script>
import AbstractMixin from '@/mixins/AbstractMixin';
export default {

    name: 'BoxValue',

    props: [
        'title',
        'value'
    ],

    mixins: [AbstractMixin]

}
</script>

<style>

.box-value {
    border: solid 1px;
    border-radius: 10px;
    overflow: hidden;
    white-space:nowrap;
    background-color: #fff;
} 

.caption {
    padding: 5px 20px;
    text-transform: uppercase;
    text-shadow: 1px 1px 2px #000;
    color: #fff;
    background-color: #03406D;
}

.value {
    margin-right: 20px;
    float: right;
    font-size: 1.5rem;
    font-weight: 500;
    color: #03406D
}
</style>