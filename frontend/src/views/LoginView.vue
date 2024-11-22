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
                                required autocomplete="current-password" placeholder="Senha" v-model="user.password" />
                            <label for="validationServerLoginSenha">Senha</label>
                            <div v-if="errors.password" id="validationServerLoginSenhaFeedback"
                                class="invalid-feedback text-start">{{
                    errors.password[0] }}</div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        <button type="button" class="btn btn-view" @click="login()">Entrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import http from '@/services/http.js'
import { mapMutations } from "vuex"

export default {

    name: "LoginView",

    data() {
        return {
            user: {
                email: 'dbrum72@gmail.com',
                password: 'password'
            },
            errors: [],
            loaderActive: false,
            text: ''
        }
    },

    methods: {

        ...mapMutations([
            'SET_USER',
            'PUSH_NOTIFICATION'
        ]),

        async login() {

            this.loaderActive = true
            this.text = 'Autenticando...'

            try {
                let url = `${process.env.VUE_APP_BACKEND_URL}/auth/login`
                let response = await http.post(url, this.user)
                
                document.cookie = 'token=' + response.data.access_token + ';SameSite=Lax'
                this.SET_USER({
                    'user_id': response.data.user_id,
                    'user_name': response.data.user_name
                })
                
                /* eslint-disable */
                this.$router.push({ name: 'Shop' })

            } catch (error) {
                if (error?.response?.status === 401) {
                    this.PUSH_NOTIFICATION({
                        type: 'erro',
                        message: 'Acesso não autorizado.'
                    })
                } else if (error?.response?.status === 403) {
                    this.PUSH_NOTIFICATION({
                        type: 'erro',
                        message: error.response.data.msg
                    })
                }
                this.$router.push({ name: 'Login' })
            }
            finally {
                this.text = ''
                this.loaderActive = false
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