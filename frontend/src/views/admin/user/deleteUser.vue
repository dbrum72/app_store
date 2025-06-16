<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CLIENTE</span>
        </div>

        <div class="p-2">
            <div class="box show">
                <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                    <span>Atenção</span>
                </div>
                <div style="margin: 10px;">
                    Confirma a exclusão do cliente "{{ client.name }}" (Id. {{ client.id }}) ?
                </div>
                <div class="text-end">
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getUser', params: { 'id': this.id }}">Cancelar</router-link>
                    <button type="button" class="btn btn-red" @click="(destroyClient(client.id))">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin';
import UserMixin from '@/mixins/UserMixin';

export default {

    name: 'DeleteClient',

    mixins: [AbstractMixin, UserMixin],

    data() {
        return {
            id: this.$route.params.id,
            client: {},
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getUser(this.id)
    }

}

</script>