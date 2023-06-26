<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Документ {{name}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <form @submit.prevent="upd">
                        <div>
                            <v-text-field :error="hasError && errors.name" :error-messages="errors.name" label="Название документ" v-model="name"></v-text-field>
                        </div>

                        <div>
                            <v-select
                                :items="houses"
                                v-model="house_id"
                                label="Дом"
                                item-text="name"
                                item-value="id"
                                :error="hasError && errors.house_id"
                                :error-messages="errors.house_id"
                            >
                                <template slot="selection" slot-scope="houses">
                                    {{ houses.item.name }}, {{ houses.item.object.name }}
                                </template>
                                <template slot="item" slot-scope="houses">
                                    {{ houses.item.name }}, {{ houses.item.object.name }}
                                </template>
                            </v-select>
                        </div>

                        <div>
                            <a :href="'/' + file.path" target="_blank">Текуший документ</a>
                        </div>

                        <div>
                            <v-file-input :error="hasError && errors.attachment" :error-messages="errors.attachment" v-model="attachment" label="Выберите новый документ"></v-file-input>
                        </div>

                        <div style="width: 100%; height: 50px">
                            <v-btn type="submit" class="primary float-right">Сохранить</v-btn>
                        </div>
                    </form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    // import axios from 'axios'

    export default {

        name: "pantryEdit",
        data(){
            return{
                id: null,
                name: null,
                house_id: null,
                attachment: null,

                houses: [],
                file: [],

                errors: [],
                hasError: false,
            }
        },
        methods:{
            fetch(){
                this.$http.get('/api/getHouses')
                    .then(response=>{
                        this.houses = response.data.houses;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })

                this.$http.get('/api/admin/documents/' + this.$route.params.id)
                    .then(response=>{
                        this.id = response.data.doc.id;
                        this.name = response.data.doc.name;
                        this.house_id = response.data.doc.house_id;
                        this.file = response.data.doc.attachment;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            upd(){
                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                if(this.attachment !== null){
                    formData.append('attachment', this.attachment)
                }
                formData.append('_method', 'PUT')
                formData.append('name', this.name)
                formData.append('house_id', this.house_id)

                this.$http.post('/api/admin/documents/' + this.id, formData, config )
                    .then(response=>{
                        this.$router.push({name: 'adminDocuments', params: {successMsg: response.data.msg} });
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
