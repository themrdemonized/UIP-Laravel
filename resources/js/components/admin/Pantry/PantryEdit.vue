<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Кладовка {{pantryName}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field label="Кладовка" v-model="pantryName"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.pantryName">{{ errors.pantryName }}</span>
                        </div>

                        <div>
                            <v-text-field label="Площадь" v-model="pantryArea"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.pantryArea">{{ errors.pantryArea }}</span>
                        </div>

                        <div>
                            <v-text-field label="Стоимость" v-model="pantryCoast"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.pantryCoast">{{ errors.pantryCoast }}</span>
                        </div>

                        <div>
                            <v-textarea
                                v-model="pantryCoordinates"
                                label="Координаты выделяемой области"
                                rows="3"
                            ></v-textarea>
                            <span class="help-block" v-if="hasError && errors.pantryCoordinates">{{ errors.pantryCoordinates }}</span>
                        </div>

                        <div>
                            <v-text-field label="dx" v-model="pantryDx"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.pantryDx">{{ errors.pantryDx }}</span>
                        </div>

                        <div>
                            <v-text-field label="dy" v-model="pantryDy"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.pantryDy">{{ errors.pantryDy }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="status"
                                v-model="pantryStatus"
                                label="Статус кладовки"
                                item-text="name"
                                item-value="id"
                            ></v-select>
                            <span class="help-block" v-if="hasError && errors.pantryStatus">{{ errors.pantryStatus }}</span>
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
                                v-model="selectHouse"
                                label="Дом"
                                item-text="name"
                                item-value="id"
                                @change="getFloors"
                            ></v-select>
                            <span class="help-block" v-if="hasError && errors.selectHouse">{{ errors.selectHouse }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="floors"
                                v-model="pantryFloor"
                                label="Этаж дома"
                                item-value="id"
                            >
                                <template slot="selection" slot-scope="floors">
                                    {{ floors.item.name }}, подъезд {{ floors.item.porch }}
                                </template>
                                <template slot="item" slot-scope="floors">
                                    {{ floors.item.name }}, подъезд {{ floors.item.porch }}
                                </template>
                            </v-select>
                            <span class="help-block" v-if="hasError && errors.pantryFloor">{{ errors.pantryFloor }}</span>
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

        name: "pantryEdit",
        data(){
            return{
                pantryId: null,
                pantryName: null,
                pantryArea: null,
                pantryCoast: null,
                pantryCoordinates: null,
                pantryDx: null,
                pantryDy: null,
                pantryStatus: null,
                pantryFloor: null,
                objects: [],
                houses: [],
                floors: [],
                status: [
                    {id: 1, name: 'Свободна'},
                    {id: 2, name: 'Продана'},
                    {id: 3, name: 'Забронирована'},
                ],

                selectObject: null,
                selectHouse: null,

                errors: [],
                hasError: false,
            }
        },
        methods:{
            getHouses(){
                this.selectHouse = null;
                this.pantryFloor = null;

                axios.get('/api/admin/getHouses', {
                    params: {
                        objectId: this.selectObject
                    }
                })
                    .then(response =>{
                        this.houses = response.data.houses;
                    })
            },
            getFloors(){
                axios.get('/api/admin/getFloors', {
                    params: {
                        selectHouse: this.selectHouse
                    }
                })
                    .then(response =>{
                        this.floors = response.data.floors;
                    })
            },
            fetch(){
                axios.get('/api/admin/editPantry',{
                    params: {
                        pantryId: this.$route.params.id
                    }
                })
                    .then(response=>{
                        this.pantryId = response.data.pantry.id;
                        this.pantryName = response.data.pantry.name;
                        this.pantryArea = response.data.pantry.area;
                        this.pantryCoast = response.data.pantry.coast;
                        this.pantryCoordinates = response.data.pantry.coordinates;
                        this.pantryDx = response.data.pantry.dx;
                        this.pantryDy = response.data.pantry.dy;
                        this.pantryStatus = response.data.pantry.status_id;

                        this.objects = response.data.objects;
                        this.houses = response.data.houses;
                        this.floors = response.data.floors;

                        this.selectObject = response.data.object.id;
                        this.selectHouse = response.data.house.id;
                        this.pantryFloor = response.data.pantry.floor_id;
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.errors = error.response.data.errors;
                    })
            },
            upd(){
                axios.post('/api/admin/updatePantry',{
                    pantryId: this.pantryId,
                    pantryName: this.pantryName,
                    pantryArea: this.pantryArea,
                    pantryCoast: this.pantryCoast,
                    pantryCoordinates: this.pantryCoordinates,
                    pantryDx: this.pantryDx,
                    pantryDy: this.pantryDy,
                    pantryStatus: this.pantryStatus,
                    pantryFloor: this.pantryFloor,
                })
                    .then(response=>{
                        this.$router.push({name: 'adminPantryShow', params: {successMsg: response.data.msg} });
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
