<template>
    <div id="login">
        <div class="areaHeader">
            <div class="text-start">
                <span>LOGIN</span>
            </div>
        </div>
        <div>
            <img src="@/assets/images/engrenagem.png">
        </div>
        <div class="card form-bg m-4">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col">
                        <div class='form-floating'>
                            <input type="email" class="form-control" :class="errors.email ? 'is-invalid' : ''"
                                id="validationServerLoginEmail" aria-describedby="validationServerLoginEmailFeedback"
                                required autocomplete="email" placeholder="Email" v-model="credentials.email" />
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
                                required autocomplete="current-password" placeholder="Senha" v-model="credentials.password" />
                            <label for="validationServerLoginSenha">Senha</label>
                            <div v-if="errors.password" id="validationServerLoginSenhaFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.password[0] }}</div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        <button type="button" class="btn btn-green" @click="submitLogin(this.credentials)">Entrar</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <span>Se ainda não possui conta, clique
                        <router-link :to="{ name: 'UserRegister' }">aqui</router-link>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex"

export default {

    name: "LoginView",

    data() {
        return {
            credentials: {
                email: 'dbrum72@gmail.com',
                password: 'password'
            },
            loaderActive: false
        }
    },

    methods: {
        ...mapMutations([
            'SET_LOADER',
            'PUSH_NOTIFICATION',
        ]),

        ...mapState(['errors']),

        ...mapActions(['login']),

        async submitLogin() {
            this.SET_LOADER({ 'active': true, 'text': 'Submetendo credenciais...' })

            try {
                await this.login(this.credentials);
                this.$router.push({ name: "Ecommerce" });
            } catch (error) {
                console.error("Erro no login:", error);
            }
            finally {
                this.SET_LOADER({ 'active': false, 'text': '' })
            }
        }
    }
}
</script>

<style scoped>
#login {
    display: flex;
    flex-flow: row wrap;
    justify-content: center;
    align-items: center;
    max-width: max-content;
}

img {
    height: 250px;
}
</style>