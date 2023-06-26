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
                            <div>
                                <v-label>Текущее изображение</v-label>
                            </div>
                            <div>
                                <img style="float: bottom" :src="'/' + img" alt="" width="200px" v-viewer>
                            </div>
                        </div>

                        <div>
                            <v-file-input :error="hasError && errors.attachment" :error-messages="errors.attachment" v-model="attachment" label="Выберать новое изображение?"></v-file-input>
                        </div>

                        <div>
                            <wysiwyg v-model="text" />
                            <span class="help-block" v-if="hasError && errors.text">{{ errors.text[0] }}</span>
                        </div>

                        <div style="width: 100%; height: 50px; padding-top: 1rem;">
                            <v-btn class="primary float-right" @click="upd()">Сохранить</v-btn>
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
                name: "",
                img: null,
                text: "",
                attachment: null,
                errors: [],
                hasError: false,
            }
        },
        methods:{
            fetch(){
                axios.get('/api/news/' + this.$route.params.id)
                    .then(response=>{
                        this.name = response.data.new.title;
                        this.img = response.data.new.photo.path;
                        this.text = response.data.new.text;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            upd(){
                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                formData.append('_method', 'PUT')
                formData.append('name', this.name)
                formData.append('text', this.text)

                if(this.attachment !== null){
                    formData.append('attachment', this.attachment)
                }

                axios.post('/api/admin/news/' + this.$route.params.id, formData , config )
                    .then(response=>{
                        this.$router.push({name: 'adminNews', params: {successMsg: response.data.msg} });
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    });
            }
        },
        created() {
            this.fetch();
        }
    }
</script>

<style scoped>

</style>
