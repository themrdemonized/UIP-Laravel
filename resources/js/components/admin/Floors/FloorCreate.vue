<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Этаж {{floorName}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field label="Этаж" v-model="floorName"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.floorName">{{ errors.floorName }}</span>
                        </div>

                        <div>
                            <v-text-field label="Количество квартир" v-model="floorFlats"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.floorFlats">{{ errors.floorFlats }}</span>
                        </div>

                        <div>
                            <v-text-field label="Количество свободных квартир" v-model="floorEmpty"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.floorEmpty">{{ errors.floorEmpty }}</span>
                        </div>

                        <div>
                            <v-text-field v-model="floorImage" label="Изображение"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.floorImage">{{ errors.floorImage }}</span>
                        </div>

                        <div>
                            <v-text-field v-model="floorViewBox"  label="ViewBox для SVG холста"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.floorViewBox">{{ errors.floorViewBox }}</span>
                        </div>

                        <div>
                            <v-textarea
                                v-model="floorCoordinates"
                                label="Координаты выделяемой области"
                                rows="3"
                            ></v-textarea>
                            <span class="help-block" v-if="hasError && errors.floorCoordinates">{{ errors.floorCoordinates }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="objects"
                                v-model="selectObject"
                                label="Жилой комплекс"
                                item-text="name"
                                item-value="id"
                                @change="getHouses"
                            ></v-select>
                        </div>

                        <div>
                            <v-select
                                :items="houses"
                                v-model="house"
                                label="Этаж дома"
                                item-text="name"
                                item-value="id"
                            ></v-select>
                            <span class="help-block" v-if="hasError && errors.house">{{ errors.house }}</span>
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
        name: "floorCreate",
        data(){
            return{
                floorName: null,
                floorFlats: null,
                floorEmpty: null,
                floorImage: '',
                floorViewBox: '',
                floorCoordinates: '',
                house: '',
                objects: [],
                selectObject: null,
                houses: [],

                errors: [],
                hasError: false,
            }
        },
        methods:{
            getHouses(){
                this.house = null;

                axios.get('/api/admin/getHouses', {
                    params: {
                        objectId: this.selectObject
                    }
                })
                    .then(response =>{
                        this.houses = response.data.houses;
                    })
            },
            fetch(){
                axios.get('/api/admin/getObjects')
                    .then(response=>{
                        this.objects = response.data.objects;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            crt(){
                axios.post('/api/admin/createFloor',{
                    floorName: this.floorName,
                    floorFlats: this.floorFlats,
                    floorEmpty: this.floorEmpty,
                    floorImage: this.floorImage,
                    floorViewBox: this.floorViewBox,
                    floorCoordinates: this.floorCoordinates,
                    house: this.house,
                })
                    .then(response=>{
                        this.$router.push({name: 'adminHouseShow', params: {successMsg: response.data.msg, id: this.house}});
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
