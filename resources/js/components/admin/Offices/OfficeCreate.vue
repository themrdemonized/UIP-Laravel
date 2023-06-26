<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    Офис {{officeName}}
                </v-card-title>
            </v-card>

            <v-card :shaped="true" class="my-5">
                <v-card-text>
                    <v-form>
                        <div>
                            <v-text-field label="Офис" v-model="officeName"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.officeName">{{ errors.officeName }}</span>
                        </div>

                        <div>
                            <v-text-field label="Площадь" v-model="officeArea"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.officeArea">{{ errors.officeArea }}</span>
                        </div>

                        <div>
                            <v-text-field label="Стоимость" v-model="officeCoast"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.officeCoast">{{ errors.officeCoast }}</span>
                        </div>

                        <div>
                            <v-textarea
                                v-model="officeCoordinates"
                                label="Координаты выделяемой области"
                                rows="3"
                            ></v-textarea>
                            <span class="help-block" v-if="hasError && errors.officeCoordinates">{{ errors.officeCoordinates }}</span>
                        </div>

                        <div>
                            <v-text-field label="dx" v-model="officeDx"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.officeDx">{{ errors.officeDx }}</span>
                        </div>

                        <div>
                            <v-text-field label="dy" v-model="officeDy"></v-text-field>
                            <span class="help-block" v-if="hasError && errors.officeDy">{{ errors.officeDy }}</span>
                        </div>

                        <div>
                            <v-select
                                :items="status"
                                v-model="officeStatus"
                                label="Статус офиса"
                                item-text="name"
                                item-value="id"
                            ></v-select>
                            <span class="help-block" v-if="hasError && errors.officeStatus">{{ errors.officeStatus }}</span>
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
                                v-model="officeFloor"
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
                            <span class="help-block" v-if="hasError && errors.officeFloor">{{ errors.officeFloor }}</span>
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
        name: "officeCreate",
        data(){
            return{
                officeName: null,
                officeArea: null,
                officeCoast: null,
                officeCoordinates: null,
                officeDx: null,
                officeDy: null,
                officeStatus: null,
                officeFloor: null,
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
                this.officeFloor = null;

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
                axios.post('/api/admin/createOffice',{
                    officeName: this.officeName,
                    officeArea: this.officeArea,
                    officeCoast: this.officeCoast,
                    officeCoordinates: this.officeCoordinates,
                    officeDx: this.officeDx,
                    officeDy: this.officeDy,
                    officeStatus: this.officeStatus,
                    officeFloor: this.officeFloor,
                })
                    .then(response=>{
                        this.$router.push({name: 'adminOfficeShow', params: {successMsg: response.data.msg} });
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
