<template>
    <div style="position:relative;">
        <head_component
            :is-light="true"
            :is-shadow="true"
            title="Бронирование"
        ></head_component>

        <div class="reserve-box">
            <div class="reserve-row">
                <div class="reserve-img">
                    <img @click="document.body.style.paddingRight = 'unset'" :src="object.img" alt="" v-viewer>
                </div>
                <div class="reserve-btn">
                    <v-btn
                        tile
                        :elevation="5"
                        @click="showModal"
                        color="btn-modal"
                        :x-large="true"
                    >
                        Забронировать
                    </v-btn>
                </div>
            </div>
        </div>

        <div class="modal modal-reserve">
            <div style="z-index: 2500; height: 100%">
                <div class="modal-close">
                    <v-icon @click="close()">
                        mdi-close
                    </v-icon>
                </div>
                <div class="modal-body">
                    <div class="modal-body-form">
                        <div class="modal-body-form-title">
                            <h3>Бронирование</h3>
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

                                <v-text-field validate-on-blur :rules="itemRules" v-model="item" label="Номер кладовки/парковки"></v-text-field>
                                <span class="help-block" v-if="has_error && errors.item">{{ errors.item[0] }}</span>
                            </v-form>
                        </div>

                        <v-btn :disabled="!valid || loading" :elevation="5" width="100%" color="btn-modal" @click="validate" tile>
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
    </div>
</template>

<script>
    import Head_component from "./layout/HeadComponent";

    import { mask } from 'vue-the-mask'

    export default {
        name: "ReserveComponent",
        directives:{
            mask,
        },
        components: {Head_component},
        data(){
            return{
                object: [],

                name: "",
                number: "",
                mask: '+7 (###) ### ## ##',
                item: '',

                valid: true,
                nameRules: [
                    v => !!v || '',
                    v => (v && v.length > 15) || 'Укажите ФИО полностью',
                ],
                numberRules: [
                    v => !!v || '',
                    v => (v && v.length >= 18) || 'Неверно указан номер',
                ],
                itemRules: [
                    v => !!v || '',
                    v => /[0-9]/.test(v) || 'Значине должно быть числовым',
                    v => (v && v.length <= 2) || 'Значение слишком длинное',
                ],

                has_error: false,
                error: '',
                errors: {},
                loading: false,
            }
        },
        methods:{
            showModal(){
                var modal = document.querySelector('.modal-reserve')
                modal.classList.toggle('show')
            },
            fetch(){
                this.$http.get('/api/objects/' + this.$route.params.id)
                    .then(response=>{
                        this.object = response.data.object
                    })
            },
            validate () {
                if (this.$refs.form.validate()) {
                    this.reserve();
                }
            },

            close(){
                document.querySelector('.modal-reserve').classList.toggle('show')
            },

            reserve(){
                this.loading = true;

                this.$http.post('/api/reserve/create', {
                    id: this.object.id,
                    name: this.name,
                    number: this.number,
                    item: this.item,
                })
                    .then(response=>{
                        this.close();
                        this.loading = false;
                    })
                    .catch(error=>{
                        this.loading = false;
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
        },
        created() {
            this.fetch();
        }
    }
</script>

<style scoped>

</style>
