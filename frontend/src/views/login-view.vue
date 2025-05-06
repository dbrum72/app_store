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
                            <input type="email" class="form-control" id="validationServerLoginEmail"
                                aria-describedby="validationServerLoginEmailFeedback" required autocomplete="email"
                                placeholder="Email" v-model="credentials.email" />
                            <label for="validationServerLoginEmail">Email</label>
                        </div>

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class='form-floating'>
                            <input type="password" class="form-control" id="validationServerLoginSenha"
                                aria-describedby="validationServerLoginSenhaFeedback" required
                                autocomplete="current-password" placeholder="Senha" v-model="credentials.password" />
                            <label for="validationServerLoginSenha">Senha</label>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        <button type="button" class="btn btn-green"
                            @click="submitLogin(this.credentials)">Entrar</button>
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
import { mapActions } from "vuex"

export default {

    name: "LoginView",

    data() {
        return {
            credentials: {
                email: 'dbrum72@gmail.com',
                password: 'password'
            }
        }
    },

    methods: {
        ...mapActions(['login']),

        async submitLogin() {
            await this.login(this.credentials);
            
            this.$router.push({ name: "Ecommerce" })
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