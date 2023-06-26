<template>
    <div>
        <v-row>
            <v-col cols="4" class="admin-price">
                <div class="admin-price-title">
                    Установить цену за м<sup>2</sup> по всему дому
                </div>
                <div class="admin-price-btn">
                    <v-btn class="primary" @click="priceUpdate(1)">
                        Выбрать дом
                    </v-btn>
                </div>

            </v-col>
            <v-col cols="4" class="admin-price">
                <div class="admin-price-title">
                    Установить цену за м<sup>2</sup> по этажу дома
                </div>
                <div class="admin-price-btn">
                    <v-btn class="primary" @click="priceUpdate(2)">
                        Выбрать этаж
                    </v-btn>
                </div>
            </v-col>
            <v-col cols="4" class="admin-price">
                <div class="admin-price-title">
                    Установить цену за м<sup>2</sup> по квартире
                </div>
                <div class="admin-price-btn">
                    <v-btn class="primary" @click="priceUpdate(3)">
                        Выбрать квартиру
                    </v-btn>
                </div>
            </v-col>
        </v-row>
        <v-row v-if="form===1">
            <v-col cols="12">
                <h2>
                    Цена по дому
                </h2>
            </v-col>
            <v-col cols="3">
                 <v-select
                     :items="objects"
                     label='Выберите комплекс'
                     item-text="name"
                     item-value="id"
                     v-model="selectObject"
                     @change="getHouses"
                 ></v-select>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="houses"
                    label='Выберите дом'
                    item-text="name"
                    item-value="id"
                    v-model="selectHouse"
                ></v-select>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    label="Цена за метр"
                    v-model="priceForArea"
                >
                </v-text-field>
            </v-col>
            <v-col  cols="3">
                <v-btn class="success" @click="updHousePrice">
                    Установить цену
                </v-btn>
            </v-col>
        </v-row>
        <v-row v-else-if="form===2">
            <v-col cols="12">
                <h2>
                    Цена по этажу
                </h2>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="objects"
                    label='Выберите комплекс'
                    item-text="name"
                    item-value="id"
                    v-model="selectObject"
                    @change="getHouses"
                ></v-select>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="houses"
                    label='Выберите дом'
                    item-text="name"
                    item-value="id"
                    v-model="selectHouse"
                    @change="getFloors"
                ></v-select>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="floors"
                    label="Выберите этаж"
                    multiple
                    item-text="name"
                    item-value="id"
                    v-model="selectFloor"
                >
                </v-select>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    label="Цена за метр"
                    v-model="priceForArea"
                >
                </v-text-field>
            </v-col>
            <v-col cols="3">
                <v-btn class="success" @click="updFloorPrice">
                    Установить цену
                </v-btn>
            </v-col>
        </v-row>
        <v-row v-else-if="form===3">
            <v-col cols="12">
                <h2>
                    Цена по квартире
                </h2>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="objects"
                    label='Выберите комплекс'
                    item-text="name"
                    item-value="id"
                    v-model="selectObject"
                    @change="getHouses"
                ></v-select>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="houses"
                    label='Выберите дом'
                    item-text="name"
                    item-value="id"
                    v-model="selectHouse"
                    @change="getFloors"
                ></v-select>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="floors"
                    label="Выберите этаж"
                    item-text="name"
                    item-value="id"
                    v-model="selectFloor"
                    @change="getFlats"
                >
                </v-select>
            </v-col>
            <v-col cols="3">
                <v-select
                    :items="flats"
                    label="Выберите квартиру"
                    multiple
                    item-text="name"
                    item-value="id"
                    v-model="selectFlat"
                >
                </v-select>
            </v-col>
            <v-col cols="3">
                <v-text-field
                    label="Цена за метр"
                    v-model="priceForArea"
                >
                </v-text-field>
            </v-col>
            <v-col cols="3">
                <v-btn class="success" @click="updFlatPrice">
                    Установить цену
                </v-btn>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "AdminPrices",
        data(){
            return{
                form: null,
                objects: [],
                houses: [],
                floors: [],
                flats: [],
                msg: [],
                priceForArea: null,

                selectObject: null,
                selectHouse: null,
                selectFloor: null,
                selectFlat: null,
            }
        },
        methods:{
            updHousePrice(){
                if(window.confirm('Вы действительно хотите установить цену в ' + this.priceForArea + ' для дома №' + this.selectHouse + '?')) {
                    axios.get('/api/admin/updHousePrice', {
                        params: {
                            selectHouse: this.selectHouse,
                            priceForArea: this.priceForArea
                        }
                    })
                        .then(response => {
                            this.msg = response.data.msg
                            this.form = null
                        })
                }
            },
            updFloorPrice(){
                if(window.confirm('Вы действительно хотите установить цену в ' + this.priceForArea + ' для этажей № ' + this.selectFloor + '?')) {
                    axios.get('/api/admin/updFloorPrice', {
                        params: {
                            selectFloor: this.selectFloor,
                            priceForArea: this.priceForArea
                        }
                    })
                        .then(response => {
                            this.msg = response.data.msg
                            this.form = null
                        })
                }
            },
            updFlatPrice(){
                if(window.confirm('Вы действительно хотите установить цену в ' + this.priceForArea + ' для квартир №' + this.selectFlat + '?')) {
                    axios.get('/api/admin/updFlatPrice', {
                        params: {
                            selectFlat: this.selectFlat,
                            priceForArea: this.priceForArea
                        }
                    })
                        .then(response => {
                            this.msg = response.data.msg
                            this.form = null
                        })
                }
            },
            priceUpdate(number){
                this.form = number;

                axios.get('/api/admin/getObjects')
                    .then(response =>{
                        this.objects = response.data.objects;
                    })
            },
            getHouses(){
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
            getFlats(){
                axios.get('/api/admin/getFlats', {
                    params: {
                        selectFloor: this.selectFloor
                    }
                })
                    .then(response =>{
                        this.flats = response.data.flats;
                    })
            }
        },
    }
</script>

<style scoped>

</style>
