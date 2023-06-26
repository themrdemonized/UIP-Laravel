<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Дом №{{name}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field :error="hasError && errors.name" :error-messages="errors.name" label="Номер дома" v-model="name"></v-text-field>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.floors" :error-messages="errors.floors" label="Количество этажей" v-model="floors"></v-text-field>
                        </div>

                        <div>
                            <v-textarea
                                v-model="description"
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
                            <v-text-field :error="hasError && errors.viewBox" :error-messages="errors.viewBox" v-model="viewBox"  label="ViewBox для SVG холста"></v-text-field>
                        </div>

                        <div>
                            <v-textarea
                                v-model="coordinates"
                                label="Координаты выделяемой области"
                                rows="3"
                                :error="hasError && errors.coordinates"
                                :error-messages="errors.coordinates"
                            ></v-textarea>
                        </div>

                        <div>
                            <v-select
                                :items="houseStatuses"
                                v-model="status_id"
                                label="Этап строительства"
                                item-text="name"
                                item-value="id"
                                :error="hasError && errors.status_id"
                                :error-messages="errors.status_id"
                            ></v-select>
                        </div>
                        <div>
                            <v-select
                                :items="houseObjects"
                                v-model="object_id"
                                label="Объект дома"
                                item-text="name"
                                item-value="id"
                                :error="hasError && errors.object_id"
                                :error-messages="errors.object_id"
                            ></v-select>
                        </div>

                        <div>
                            <v-text-field :error="hasError && errors.empty_flats" :error-messages="errors.empty_flats" v-model="empty_flats"  label="Свободных квартир"></v-text-field>
                        </div>
                        <div>
                            <v-text-field :error="hasError && errors.info" :error-messages="errors.info" v-model="info"  label="Информация о доме"></v-text-field>
                        </div>
                        <div>
                            <v-text-field :error="hasError && errors.location" :error-messages="errors.location" v-model="location"  label="Расположение"></v-text-field>
                        </div>
                        <div>
                            <v-text-field :error="hasError && errors.video" :error-messages="errors.video" v-model="video"  label="Ссылка на видео-трансляцию"></v-text-field>
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
    export default {
        name: "HouseEdit",
        data(){
            return{
                id: null,
                name: null,
                floors: null,
                description: null,
                img: null,
                object_id: null,
                coordinates: null,
                viewBox: null,
                status_id: null,
                empty_flats: null,
                info: null,
                location: null,
                video: null,

                houseStatuses: [
                    {id: 1, name: 'Строится'},
                    {id: 2, name: 'Построен'}
                ],
                houseObjects: [],

                errors: [],
                hasError: false,
            }
        },
        methods:{
            fetch(){
                this.$http('/api/objects')
                    .then(response=>{
                        this.houseObjects = response.data.objects;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            crt(){
                this.$http.post('/api/admin/createHouse',{
                    name: this.name,
                    floors: this.floors,
                    coordinates: this.coordinates,
                    img: this.img,
                    viewBox: this.viewBox,
                    description: this.description,
                    status_id: this.status_id,
                    object_id: this.object_id,
                    empty_flats: this.empty_flats,
                    info: this.info,
                    location: this.location,
                    video: this.video
                })
                    .then(response=>{
                        this.$router.push({name: 'adminObjectShow', params: {successMsg: response.data.msg, id: this.object_id}});
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
