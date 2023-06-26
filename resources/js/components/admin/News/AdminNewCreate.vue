<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Новость - "{{name}}"
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field :error="hasError && errors.name" :error-messages="errors.name" label="Заголовок" v-model="name"></v-text-field>
                        </div>

                        <div>
                            <v-file-input :error="hasError && errors.attachment" :error-messages="errors.attachment" v-model="attachment" label="Выберите изображение"></v-file-input>
                        </div>

                        <div>
                            <wysiwyg v-model="text" />
                            <span class="help-block" v-if="hasError && errors.text">{{ errors.text[0] }}</span>
                        </div>

                        {{text}}

                        <div style="width: 100%; height: 50px; padding-top: 1rem">
                            <v-btn class="primary float-right" @click="crt()">Сохранить</v-btn>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import axios from 'axios'

    export default {

        name: "NewEdit",
        data(){
            return{
                id: null,
                name: "",
                text: "",
                attachment: null,

                errors: [],
                hasError: false,
            }
        },
        methods:{
            crt(){
                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                formData.append('attachment', this.attachment)
                formData.append('name', this.name)
                formData.append('text', this.text)

                axios.post('/api/admin/news', formData , config )
                    .then(response=>{
                        this.$router.push({name: 'adminNews', params: {successMsg: response.data.msg} });
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    });
            }
        },
    }
</script>

<style scoped>

</style>
