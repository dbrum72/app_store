<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CLIENTE (endereço)</span>
        </div>

        <div class="p-2">
            <div class="box show">
                <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                    <span>Atenção</span>
                </div>
                <div style="margin: 10px;">
                    Confirma a exclusão de endereço do cliente "{{ address.street }}" (Id. {{ address.id }}) ?
                </div>
                <div class="text-end">
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getUser', params: { 'id': address.client_id }}">Cancelar</router-link>
                    <button type="button" class="btn btn-red" @click="(destroyAddress(address.id, address.client_id))">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin';
import UserAddressMixin from '@/mixins/UserAddressMixin';

export default {

    name: 'DeleteClient',

    mixins: [AbstractMixin, UserAddressMixin],

    data() {
        return {
            id: this.$route.params.id,
            address: {},
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchAddress(this.id)
    }

}

</script>