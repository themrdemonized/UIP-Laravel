<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    {{name}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field :error="hasError && errors.name" :error-messages="errors.name" label="Название" v-model="name"></v-text-field>
                        </div>

                        <div>
                            <v-textarea
                                v-model="description"
                                name="input-7-1"
                                label="Описание"
                                rows="3"
                                :error="hasError && errors.description"
                                :error-messages="errors.description"
                            ></v-textarea>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.img" :error-messages="errors.img" v-model="img" label="Изображение"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.viewBox" :error-messages="errors.viewBox" v-model="viewBox"  label="ViewBox"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.coordinates" :error-messages="errors.coordinates" v-model="coordinates"  label="Координаты"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.empty_flats" :error-messages="errors.empty_flats" v-model="empty_flats"  label="Свободных квартир"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.empty_parking" :error-messages="errors.empty_parking" v-model="empty_parking"  label="Свободных парковок"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.empty_pantry" :error-messages="errors.empty_pantry" v-model="empty_pantry"  label="Свободных кладовок"></v-text-field>
                        </div>

                        <div style="width: 100%; height: 50px">
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

        name: "ObjectEdit",
        data(){
            return{
                name: null,
                description: null,
                img: null,
                viewBox: null,
                coordinates: null,
                empty_flats: null,
                empty_parking: null,
                empty_pantry: null,

                errors: [],
                hasError: false,
            }
        },
        methods:{
            crt(){
                axios.post('/api/admin/createObject',{
                    name: this.name,
                    description: this.description,
                    img: this.img,
                    viewBox: this.viewBox,
                    coordinates: this.coordinates,
                    empty_flats: this.empty_flats,
                    empty_parking: this.empty_parking,
                    empty_pantry: this.empty_pantry,
                })
                    .then(response=>{
                        this.$router.push({name: 'adminObjects', params: {successMsg: response.data.msg}});
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
