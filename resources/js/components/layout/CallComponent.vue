<template>
    <div class="modal modal-callback">
        <div class="" style="z-index: 1700; height: 100%">
            <div class="modal-close">
                <v-icon @click="close()">
                    mdi-close
                </v-icon>
            </div>
            <div class="modal-body">
                <div class="modal-body-form">
                        <div class="modal-body-form-title">
                            <h3>Заказать звонок</h3>
                        </div>

                        <div class="modal-body-form-inputs">
                            <v-form
                                autocomplete="off"
                                ref="form"
                                v-model="valid"
                                lazy-validation
                            >
                                <v-text-field validate-on-blur :rules="nameRules" v-model="name" label="ФИО"></v-text-field>
                                <span class="help-block" v-if="has_error && errors.name">{{ errors.name[0] }}</span>

                                <v-text-field validate-on-blur :rules="numberRules" v-mask="mask" v-model="number" label="Номер телефона"></v-text-field>
                                <span class="help-block" v-if="has_error && errors.number">{{ errors.number[0] }}</span>
                            </v-form>
                        </div>

<!--                        <v-btn @click="callBack" :tile="true" :elevation="5" width="100%" color="btn-modal">Отправить заявку</v-btn>-->
                    <v-btn :disabled="!valid || loading" :elevation="5" width="100%" color="btn-modal" @click="validate" tile >
                        <v-progress-circular
                            v-if="loading"
                            :size="20"
                            :width="2"
                            color="black"
                            indeterminate
                            style="margin-right: 1rem"
                        ></v-progress-circular>
                        Отправить заявку
                    </v-btn>

                        <div class="modal-agreement">
                            Нажимая кнопку «Отправить» вы подтверждаете свое
                            <router-link to="/agreement" class="modal-agreement-link">
                                согласие на обработку персональных данных
                            </router-link>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mask } from 'vue-the-mask'

    export default {
        name: "CallComponent",
        directives:{
            mask,
        },
        data(){
            return{
                loading: false,

                number: '',
                name: null,
                mask: '+7 (###) ### ## ##',

                valid: true,
                nameRules: [
                    v => !!v || '',
                    v => (v && v.length > 15) || 'Укажите ФИО полностью',
                ],
                numberRules: [
                    v => !!v || '',
                    v => (v && v.length >= 18) || 'Неверно указан номер',
                ],

                has_error: false,
                error: '',
                errors: {},
            }
        },
        methods:{
            validate () {
                if (this.$refs.form.validate()) {
                    this.callBack();
                }
            },

            callBack(){
                this.loading = true;
                this.$http.post('/api/createCallBack', {
                    name: this.name,
                    number: this.number
                })
                    .then(response=>{
                        this.msg = response.data.msg;
                        this.close();
                        this.loading = false;
                    })
                    .catch(error=>{
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                        this.loading = false;
                    })
            },

            close(){
                var modal = document.querySelector('.modal-callback')
                modal.classList.toggle('show')
            }
        }

    }
</script>

<style scoped>

</style>
