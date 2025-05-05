<template>
    <div class="register-form">
        <div class="card form-bg m-4">
            <div class="card-body">
                <h2>Cadastro de Usuário</h2>

                <div class="row mb-3">
                    <div class="col">
                        <div class='form-floating'>
                            <input type="text" class="form-control" :class="errors.name ? 'is-invalid' : ''"
                                id="validationServerRegisterName"
                                aria-describedby="validationServerRegisterNameFeedback" required autocomplete="name"
                                placeholder="Nome" v-model="user.name" />
                            <label for="validationServerRegisterName">Nome</label>
                            <div v-if="errors.name" id="validationServerRegisterNameFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.name[0] }}</div>
                        </div>

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class='form-floating'>
                            <input type="email" class="form-control" :class="errors.email ? 'is-invalid' : ''"
                                id="validationServerLoginEmail" aria-describedby="validationServerLoginEmailFeedback"
                                required autocomplete="email" placeholder="Email" v-model="user.email" />
                            <label for="validationServerLoginEmail">Email</label>
                            <div v-if="errors.email" id="validationServerLoginEmailFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.email[0] }}</div>
                        </div>

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class='form-floating'>
                            <input type="password" class="form-control" :class="errors.password ? 'is-invalid' : ''"
                                id="validationServerLoginSenha" aria-describedby="validationServerLoginSenhaFeedback"
                                required autocomplete="password" placeholder="Senha" v-model="user.password" />
                            <label for="validationServerLoginSenha">Senha</label>
                            <div v-if="errors.password" id="validationServerLoginSenhaFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.password[0] }}</div>
                        </div>

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class='form-floating'>
                            <input type="password" class="form-control"
                                :class="errors.password_confirmation ? 'is-invalid' : ''"
                                id="validationServerLoginSenhaConfirmation"
                                aria-describedby="validationServerLoginSenhaConfirmationFeedback" required
                                autocomplete="password_confirmation" placeholder="Senha"
                                v-model="user.password_confirmation" />
                            <label for="validationServerLoginSenhaConfirmation">Confirmar Senha</label>
                            <div v-if="errors.password_confirmation" id="validationServerLoginSenhaConfirmationFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.password_confirmation[0] }}</div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        <button type="button" class="btn btn-green" @click="this.register(this.user)">Cadastrar</button>
                    </div>
                </div>

                <p v-if="error" class="error">{{ error }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
    name: 'UserRegister',

    data() {
        return {
            user: {},
            errors: [],
        }
    },

    computed: {
        ...mapState(['errors']),
    },

    methods: {
        ...mapActions(['register']),
    },
}
</script>

<style scoped>
.register-form {
    max-width: 400px;
    margin: auto;
}

.error {
    color: red;
}
</style>