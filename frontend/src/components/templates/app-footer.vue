<template>
    <div class="footer">
        Footer
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AbstractMixin from '@/mixins/AbstractMixin'

export default {

    name: "AppFooter",

    mixins: [
        AbstractMixin
    ],

    data() {
        return {
            value: 0
        }
    },

    computed: {
        ...mapGetters([
            'getSumCart'
        ]),

        formattedValue() {
            return this.toCurrency(this.value)
        },

        moneyChange() {
            return this.toCurrency(this.value - this.getSumCart)
        }
    },

    methods: {
        sumCart() {
            return this.getSumCart
        },

        updateValue(inputValue) {
            const cleanValue = inputValue.replace(/[^\d.-]/g, '');
            this.value = parseFloat(cleanValue);
        }
    }
}
</script>

<style>
.footer {
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 15px;
    bottom: 0px;
    border-top: solid 2px rgba(255, 255, 255, 0.1);
    background-color: #4F79A4
}

.copyright {
    width: 100%;
}
</style>