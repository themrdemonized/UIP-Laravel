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

        name: "floorEdit",
        data(){
            return{
                floorId: null,
                floorName: null,
                floorFlats: null,
                floorEmpty: null,
                floorImage: '',
                floorViewBox: '',
                floorCoordinates: '',
                objects: [],
                selectObject: null,
                houses: [],
                house: null,

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
                axios.get('/api/admin/editFloor',{
                    params: {
                        floorId: this.$route.params.id
                    }
                })
                    .then(response=>{
                        this.floorId = response.data.floor.id;
                        this.floorName = response.data.floor.name;
                        this.floorFlats = response.data.floor.flats;
                        this.floorEmpty = response.data.floor.flats_empty;
                        this.floorImage = response.data.floor.img;
                        this.floorViewBox = response.data.floor.viewBox;
                        this.floorCoordinates = response.data.floor.coordinates;

                        this.objects = response.data.objects;
                        this.selectObject = response.data.object.id;

                        this.house = response.data.house.id;
                        this.houses = response.data.houses;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            upd(){
                axios.post('/api/admin/updateFloor',{
                    floorId: this.floorId,
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

<style scoped>

</style>
