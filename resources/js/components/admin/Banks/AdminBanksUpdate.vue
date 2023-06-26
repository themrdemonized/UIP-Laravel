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
                            <v-text-field :error="hasError && errors.name" :error-messages="errors.name" label="Название банка" v-model="name"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.link" :error-messages="errors.link" label="Ссылка на банк" v-model="link"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.img" :error-messages="errors.img" label="Изображение" v-model="img"></v-text-field>
                        </div>

                        <div>
                            <v-select
                                :items="houses"
                                v-model="chooseHouses"
                                label="Дом"
                                item-text="name"
                                item-value="id"
                                :error="hasError && errors.houses"
                                :error-messages="errors.houses"
                                multiple
                            >
                                <template slot="selection" slot-scope="houses">
                                    {{ houses.item.name }}, {{ houses.item.object.name }}
                                </template>
                                <template slot="item" slot-scope="houses">
                                    {{ houses.item.name }}, {{ houses.item.object.name }}
                                </template>
                            </v-select>
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
                link: null,
                img: null,
                chooseHouses: [],
                attachment: null,

                houses: [],

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

                this.$http.get('/api/admin/banks/' + this.$route.params.id)
                    .then(response=>{
                        this.id = response.data.bank.id;
                        this.name = response.data.bank.name;
                        this.link = response.data.bank.link;
                        this.img = response.data.bank.img;

                        for(let i in response.data.bank.houses){
                            this.chooseHouses.push(response.data.bank.houses[i].id);
                        }

                        console.log(this.chooseHouses);

                        //this.houses = response.data.bank.houses;
                        // this.file = response.data.bank.attachment;
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

                for(let i=0; i<this.chooseHouses.length; i++){
                    formData.append('houses[]', this.chooseHouses[i]);
                }

                // formData.append('houses[]', this.chooseHouses)

                this.$http.post('/api/admin/banks/' + this.id, formData, config )
                    .then(response=>{
                        this.$router.push({name: 'adminBanks', params: {successMsg: response.data.msg} });
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
