<template>
    <div class="auth-block">
        <v-row class="d-flex justify-center">
            <v-col cols="4">
                <v-card>
                    <v-card-title>
                        Вход
                    </v-card-title>
                    <v-card-subtitle v-if="has_error" style="padding-top: 1.5rem">
                        <v-alert v-model="has_error" dismissible type="error">
                            Вы ввели неверные данные!
                        </v-alert>
                    </v-card-subtitle>
                    <v-card-text>
                        <v-form
                            autocomplete="off"
                            ref="form"
                            v-model="valid"
                            lazy-validation
                            @submit.prevent="validate"
                        >
                            <v-text-field :rules="emailRules" label="Почта" outlined v-model="email" required type="email"></v-text-field>
                            <v-text-field :rules="passwordRules" label="Пароль" outlined v-model="password" required type="password"></v-text-field>

                            <div>
                                <v-btn
                                    type="submit"
                                    :disabled="!valid"
                                    color="primary"
                                    class="auth-btn"
                                    tile
                                    height="50"
                                >
                                    Войти
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    export default {

        data() {
            return {
                valid: true,
                emailRules: [ v => !!v || ''],
                passwordRules: [ v => !!v || ''],
                email: null,
                password: null,
                has_error: false
            }
        },
        mounted() {
            //
        },
        methods: {
            validate () {
                if (this.$refs.form.validate()) {
                    this.login();
                }
            },
            login() {
                // get the redirect object
                var redirect = this.$auth.redirect()
                var app = this
                this.$auth.login({
                    params: {
                        email: app.email,
                        password: app.password
                    },
                    success: function() {
                        // handle redirection
                        const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'AdminApp' : 'UserApp'
                        this.$router.push({name: redirectTo})
                    },
                    error: function() {
                        app.has_error = true
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            }
        }
    }
</script>
