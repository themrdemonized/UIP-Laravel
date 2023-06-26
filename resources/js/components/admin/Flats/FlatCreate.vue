<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Квартира {{flatName}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field label="Номер" v-model="flatName"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatName">{{ errors.flatName }}</span>
                        </div>

                        <div>
                            <v-text-field label="Площадь" v-model="flatArea"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatArea">{{ errors.flatArea }}</span>
                        </div>

                        <div>
                            <v-text-field label="Цена за квадратный метр" v-model="flatAreaCoast"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatAreaCoast">{{ errors.flatAreaCoast }}</span>
                        </div>

                        <div>
                            <v-text-field label="Стоимость" v-model="coast"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatCoast">{{ errors.flatCoast }}</span>
                        </div>

                        <div>
                            <v-text-field label="Комнат" v-model="flatRooms"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatRooms">{{ errors.flatRooms }}</span>
                        </div>

                        <div>
                            <v-checkbox
                                v-model="flatLoggia"
                                label="Лоджия"
                            ></v-checkbox>
                            <span class="help-block" v-if="hasError && errors.flatLoggia">{{ errors.flatLoggia }}</span>
                        </div>

                        <div>
                            <v-text-field v-model="flatUid" label="uid"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatUid">{{ errors.flatUid }}</span>
                        </div>

                        <div>
                            <v-text-field v-model="flatImage" label="Изображение"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatImage">{{ errors.flatImage }}</span>
                        </div>

                        <div>
                            <v-textarea
                                v-model="flatCoordinates"
                                label="Координаты выделяемой области"
                                rows="3"
                            ></v-textarea>
                            <span class="help-block" v-if="hasError && errors.flatCoordinates">{{ errors.flatCoordinates }}</span>
                        </div>
                        <div>
                            <v-text-field v-model="flatDx"  label="dx"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatDx">{{ errors.flatDx }}</span>
                        </div>
                        <div>
                            <v-text-field v-model="flatDy"  label="dy"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.flatDy">{{ errors.flatDy }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="status"
                                v-model="flatStatus"
                                label="Статус квартиры"
                                item-text="name"
                                item-value="id"
                            ></v-select>
                            <span class="help-block" v-if="hasError && errors.flatStatus">{{ errors.flatStatus }}</span>
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
                            <span class="help-block" v-if="hasError && errors.selectObject">{{ errors.selectObject }}</span>
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
                                v-model="selectFloor"
                                label="Этаж дома"
                                item-value="id"
                            >
                                <template slot="selection" slot-scope="floors">
                                    {{ floors.item.name }} подъезд {{ floors.item.porch }}
                                </template>
                                <template slot="item" slot-scope="floors">
                                    {{ floors.item.name }} подъезд {{ floors.item.porch }}
                                </template>
                            </v-select>
                            <span class="help-block" v-if="hasError && errors.selectFloor">{{ errors.selectFloor }}</span>
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

        name: "flatEdit",
        data(){
            return{
                flatName: null,
                flatArea: null,
                flatAreaCoast: null,
                flatRooms: null,
                flatCoast: null,
                flatLoggia: null,
                flatUid: '',
                flatImage: '',
                flatCoordinates: '',
                flatDx: '',
                flatDy: '',
                flatStatus: null,

                status: [
                    {id: 1, name: 'Свободна'},
                    {id: 2, name: 'Продана'},
                    {id: 3, name: 'Забронирована'},
                ],
                objects: [],
                houses: [],
                floors: [],

                selectObject: null,
                selectHouse: null,
                selectFloor: null,

                errors: [],
                hasError: false,
            }
        },
        computed:{
            coast: function () {
                return this.flatArea * this.flatAreaCoast
            }
        },
        methods:{
            getHouses(){
                this.selectHouse = null;
                this.selectFloor = null;

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
                axios.get('/api/admin/getObjects')
                    .then(response=>{
                        this.objects = response.data.objects;
                    })
            },
            crt(){
                axios.post('/api/admin/createFlat',{
                    flatName: this.flatName,
                    flatArea: this.flatArea,
                    flatAreaCoast: this.flatAreaCoast,
                    flatRooms: this.flatRooms,
                    flatCoast: this.coast,
                    flatLoggia: this.flatLoggia,
                    flatImage: this.flatImage,
                    flatCoordinates: this.flatCoordinates,
                    flatUid: this.flatUid,
                    flatDx: this.flatDx,
                    flatDy: this.flatDy,
                    flatStatus: this.flatStatus,
                    selectFloor: this.selectFloor,
                })
                    .then(response=>{
                        this.$router.push({name: 'adminFloorShow', params: {successMsg: response.data.msg, id: this.selectFloor}});
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
