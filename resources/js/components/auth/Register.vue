<template>

    <div class="auth-block">
        <v-row class="d-flex justify-center">
            <v-col cols="4">
                <v-card>
                    <v-card-title>
                        Регистрация
                    </v-card-title>
                    <v-card-subtitle v-if="has_error" style="padding-top: 1.5rem">
                        <v-alert v-model="has_error" dismissible type="error">
                            <span>Ошибка валидации!</span>
                        </v-alert>
                    </v-card-subtitle>
                    <v-card-text>
                        <v-form
                            autocomplete="off"
                            ref="form"
                            v-model="valid"
                            lazy-validation
                        >
                            <div>
                                <v-text-field :rules="emailRules" label="Почта" outlined v-model="email" required type="email"></v-text-field>
                                <span class="help-block" v-if="has_error && errors.email">{{ errors.email[0] }}</span>
                            </div>

                            <div>
                                <v-text-field :rules="passwordRules" label="Пароль" outlined v-model="password" required type="password"></v-text-field>
                                <span class="help-block" v-if="has_error && errors.password">{{ errors.password[0] }}</span>
                            </div>

                            <div>
                                <v-text-field :rules="passwordConfirmRules" label="Подтвердите пароль" outlined v-model="password_confirmation" required type="password"></v-text-field>
                            </div>

                            <div>
                                <v-btn
                                    :disabled="!valid"
                                    color="primary"
                                    class="auth-btn"
                                    @click="validate"
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

<!--    <div class="container">-->
<!--        <div class="card card-default">-->
<!--            <div class="card-header">Inscription</div>-->
<!--            <div class="card-body">-->
<!--                <div class="alert alert-danger" v-if="has_error && !success">-->
<!--                    <p v-if="error == 'registration_validation_error'">Ошибка валидации!</p>-->
<!--                    <p v-else>Erreur, impossible de s'inscrire pour le moment. Si le problème persiste, veuillez contacter un administrateur.</p>-->
<!--                </div>-->
<!--                <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">-->
<!--                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">-->
<!--                        <label for="email">E-mail</label>-->
<!--                        <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email">-->
<!--                        <span class="help-block" v-if="has_error && errors.email">{{ errors.email }}</span>-->
<!--                    </div>-->
<!--                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">-->
<!--                        <label for="password">Mot de passe</label>-->
<!--                        <input type="password" id="password" class="form-control" v-model="password">-->
<!--                        <span class="help-block" v-if="has_error && errors.password">{{ errors.password }}</span>-->
<!--                    </div>-->
<!--                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">-->
<!--                        <label for="password_confirmation">Confirmation mot de passe</label>-->
<!--                        <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">-->
<!--                    </div>-->
<!--                    <button type="submit" class="btn btn-default">Inscription</button>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>
<script>
    export default {
        data() {
            return {
                valid: true,

                email: '',
                password: '',
                password_confirmation: '',
                has_error: false,

                emailRules: [ v => !!v || ''],
                passwordRules: [ v => !!v || ''],
                passwordConfirmRules: [ v => !!v || ''],

                error: '',
                errors: {},
                success: false
            }
        },
        methods: {
            validate () {
                if (this.$refs.form.validate()) {
                    this.register();
                }
            },
            register() {
                var app = this
                this.$auth.register({
                    data: {
                        email: app.email,
                        password: app.password,
                        password_confirmation: app.password_confirmation
                    },
                    success: function () {
                        app.success = true
                        this.$router.push({name: 'login', params: {successRegistrationRedirect: true}})
                    },
                    error: function (res) {
                        console.log(res.response.data.errors)
                        app.has_error = true
                        app.error = res.response.data.error
                        app.errors = res.response.data.errors || {}
                    }
                })
            }
        }
    }
</script>
