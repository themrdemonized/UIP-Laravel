<template>
    <div>
        <div v-if="hasMsg">
            <v-alert v-model="hasMsg" text dismissible type="success">
                {{sMsg}}
            </v-alert>
        </div>
        <div v-if="hasError">
            <v-alert v-model="hasError" text dismissible type="error">
                {{sMsg}}
            </v-alert>
        </div>

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="2" style="display: flex; align-items: flex-end; margin-right: 5rem">
                        Поиск квартиры
                    </v-col>
                    <v-spacer>
                    </v-spacer>
                    <v-col cols="4">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-search"
                            label="Найти"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-subtitle>
                <v-row>
                    <v-col cols="2">
                        <v-select
                            :items="status"
                            item-text="name"
                            item-value="id"
                            v-model="selectStatus"
                            label="Выберите статус"
                            @change="fetch"
                        >
                        </v-select>
                    </v-col>
                    <v-col cols="2">
                        <v-select
                            :items="objects"
                            label='Выберите комплекс'
                            item-text="name"
                            item-value="id"
                            v-model="selectObject"
                            @change="getHouses"
                        ></v-select>
                    </v-col>
                    <v-col cols="2">
                        <v-select
                            :items="houses"
                            label='Выберите дом'
                            item-text="name"
                            item-value="id"
                            v-model="selectHouse"
                            @change="getFloors"
                        ></v-select>
                    </v-col>
                    <v-col cols="2">
                        <v-select
                            :items="floors"
                            label="Выберите этаж"
                            item-text="name"
                            item-value="id"
                            v-model="selectFloor"
                            @change="fetch"
                        >
                        </v-select>
                    </v-col>
                    <v-spacer></v-spacer>
                    <v-col cols="2" style="display: flex; justify-content: center; align-items: center">
                        <v-btn tile :elevation="5" class="primary" @click="dropFilter">
                            Сбросить фильтр
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-subtitle>

            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">№ квартиры</th>
                        <th class="text-center">Статус</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id" >
                        <td class="text-left">{{ item.name }}</td>

                        <td v-if="item.status_id === 1" class="text-center">Свободна</td>
                        <td v-if="item.status_id === 2" class="text-center">Продана</td>
                        <td v-if="item.status_id === 3" class="text-center">Забронирована</td>

                        <td class="text-right">
                            <v-icon @click="showFlat(item.id)" class="crud-icon-show" size="18">mdi-eye-outline</v-icon>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card>
    </div>

</template>

<script>
    import axios from 'axios'

    export default {
        name: "AdminRequests",
        props:{
            successMsg: '',
            pFlatStatus:{
                type: Number,
                default: null
            }
        },
        data(){
            return {
                status: [
                    { id: null, name: 'Все'},
                    { id: 1, name: 'Свободна'},
                    { id: 2, name: 'Продана'},
                    { id: 3, name: 'Забронирована'},
                ],
                selectStatus: null,
                search: '',

                flats: [],
                objects: [],
                houses: [],
                floors: [],
                selectObject: null,
                selectHouse: null,
                selectFloor: null,

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.flats.filter(function (elem) {
                    if(comp==='') return true;
                    else return elem.name.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            fetch(){
                axios.get('/api/admin/findFlats',{
                    params:{
                        selectStatus: this.selectStatus,
                        selectObject: this.selectObject,
                        selectHouse: this.selectHouse,
                        selectFloor: this.selectFloor,
                    }
                })
                    .then(response=>{
                        this.flats = response.data.flats
                        this.objects = response.data.objects
                    })
            },
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
                        this.fetch();
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
                        this.fetch();
                    })
            },
            dropFilter(){
                this.selectStatus = null;
                this.selectObject = null;
                this.selectHouse = null;
                this.selectFloor = null;
                this.fetch();
            },
            showFlat(id){
                this.$router.push({ name: 'adminShowFlat', params: { id: id } })
            }
        },

        created() {
            if(this.pFlatStatus !== null){
                this.selectStatus = this.pFlatStatus;
            }

            this.fetch();
        },
        mounted() {
            if(this.sMsg !== undefined){
                this.hasMsg = true;
            }

        }
    }
</script>

<style scoped>
    .crud-icon-link{
        text-decoration: none;
    }
    .crud-icon-show:hover{
        color: #38c172;
    }
    .crud-icon-edit:hover{
        color: #3490dc;
    }
    .crud-icon-delete:hover{
        color: #e3342f;
    }
</style>
