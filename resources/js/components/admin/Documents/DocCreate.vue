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
                    <form @submit.prevent="crt">
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

                        <div class="form-group">
                            <div class="custom-file">
                                <v-file-input :error="hasError && errors.attachment" :error-messages="errors.attachment" v-model="attachment" label="Выберите документ"></v-file-input>
                            </div>
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
    import axios from 'axios'

    export default {

        name: "docCreate",
        data(){
            return{
                name: "",
                house_id: null,
                houses: [],
                attachment: null,

                errors: [],
                hasError: false,
            }
        },
        methods:{
            fetch(){
                axios.get('/api/getHouses')
                    .then(response=>{
                        this.houses = response.data.houses;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            crt(){
                const config = { 'content-type': 'multipart/form-data' }
                const formData = new FormData()
                if(this.attachment !== null){
                    formData.append('attachment', this.attachment)
                }
                formData.append('name', this.name)
                formData.append('house_id', this.house_id)

                axios.post('/api/admin/documents', formData , config )
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
