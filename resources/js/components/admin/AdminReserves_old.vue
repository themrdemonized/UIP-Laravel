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
                    <v-col cols="2" style="display: flex; align-items: center;">
                        Бронирование
                    </v-col>
                    <v-col cols="2">
                        <v-select
                            :items="show"
                            item-text="name"
                            item-value="id"
                            v-model="showItem"
                            label="Показать"
                            @change="fetch"
                        ></v-select>
                    </v-col>
                    <v-col cols="2">
                        <v-select
                            :items="status"
                            item-text="name"
                            item-value="id"
                            v-model="selectStatus"
                            label="Статус"
                            @change="fetch"
                        >
                        </v-select>
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

            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Номер</th>
                        <th class="text-center">ФИО</th>
                        <th class="text-center">Комплекс</th>
                        <th class="text-center">Дом</th>
                        <th class="text-center">Этаж</th>
                        <th v-if="showItem===1" class="text-center">Квартира</th>
                        <th v-if="showItem===2" class="text-center">Офис</th>
                        <th v-if="showItem===3" class="text-center">Кладовка</th>
                        <th class="text-center">Статус</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in filteredList" :key="item.id" >
                        <td @click="showModalFlat(item.id)" class="text-left">{{ item.number }}</td>
                        <td @click="showModalFlat(item.id)" class="text-center">{{ item.name }}</td>
                        <td @click="showModalFlat(item.id)" class="text-center">{{ item.name_object }}</td>
                        <td @click="showModalFlat(item.id)" class="text-center">{{ item.name_house }}</td>
                        <td @click="showModalFlat(item.id)" class="text-center">{{ item.name_floor }}</td>
                        <td v-if="showItem===1" @click="showModalFlat(item.id)" class="text-center">{{ item.name_flat }}</td>
                        <td v-if="showItem===2" @click="showModalFlat(item.id)" class="text-center">{{ item.name_office }}</td>
                        <td v-if="showItem===3" @click="showModalFlat(item.id)" class="text-center">{{ item.name_pantry }}</td>
                        <td @click="showModalFlat(item.id)" v-if="item.status === 1" class="text-center">Новый</td>
                        <td @click="showModalFlat(item.id)" v-if="item.status === 2" class="text-center">Просмотрен</td>
                        <td class="text-right">
                            <v-dialog v-model="dialog" persistent max-width="600px">
                                <template v-slot:activator="{ on }">
                                    <v-icon @click="showModalFlat(item)" class="crud-icon-show" size="18" v-on="on">mdi-eye-outline</v-icon>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">Звонок</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col v-if="showItem === 1" cols="12">
                                                    {{itemFlatObject}}->Дом №{{itemFlatHouse}}->Этаж {{itemFlatFloor}}->Квартира №{{itemFlat}}
                                                </v-col>
                                                <v-col v-if="showItem === 2" cols="12">
                                                    {{itemFlatObject}}->Дом №{{itemFlatHouse}}->Этаж {{itemFlatFloor}}->Офис №{{itemFlat}}
                                                </v-col>
                                                <v-col v-if="showItem === 3" cols="12">
                                                    {{itemFlatObject}}->Дом №{{itemFlatHouse}}->Этаж {{itemFlatFloor}}->Кладовка №{{itemFlat}}
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-text-field
                                                        v-model="itemName"
                                                        label="ФИО"
                                                        :disabled="true"
                                                    >
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-text-field
                                                        v-model="itemNumber"
                                                        label="Номер"
                                                        :disabled="true"
                                                    >
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-checkbox
                                                        v-model="statusChecked"
                                                        label="Просмотрен"
                                                        @change="changeStatus"
                                                    ></v-checkbox>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn v-if="showItem===1" color="blue" text @click="$router.push({name: 'adminShowFlat', params: {id: itemFlatId} })">Перейти к квартире</v-btn>
                                        <v-btn v-if="showItem===2" color="blue" text @click="$router.push({name: 'adminOfficeUpdate', params: {id: itemFlatId} })">Перейти к офису</v-btn>
                                        <v-btn v-if="showItem===3" color="blue" text @click="$router.push({name: 'adminPantryEdit', params: {id: itemFlatId} })">Перейти к кладовке</v-btn>
                                        <v-btn color="blue darken-1" text @click="dialog = false">Закрыть</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>

                            <v-icon class="crud-icon-delete" @click="deleteCall(item.id)" size="18">mdi-delete</v-icon>

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
            successMsg: ''
        },
        data(){
            return {
                dialog: false,
                itemId: '',
                itemName: '',
                itemNumber: '',
                itemFlat: {},
                itemFlatId: null,
                itemFlatFloor: '',
                itemFlatHouse: '',
                itemFlatObject: '',
                statusChecked: false,

                status: [
                    { id: null, name: 'Все' },
                    { id: 1, name: 'Новые' },
                    { id: 2, name: 'Просмотренные' },
                ],

                show: [
                    { id: 1, name: 'Квартиры' },
                    { id: 2, name: 'Офисы' },
                    { id: 3, name: 'Кладовки' },
                ],

                showItem: 1,

                selectStatus: null,

                search: '',

                reserves: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.reserves.filter(function (elem) {
                    if(comp==='') return true;
                    else return elem.name.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            showModalFlat(item){

                {
                    this.itemId = null;
                    this.itemName = null;
                    this.itemNumber = null;
                    this.itemFlatId = null;
                }

                if(this.showItem === 1){
                    this.itemId = item.id;
                    this.itemName = item.name;
                    this.itemNumber = item.number;
                    this.itemFlatId = item.flat_id;

                    if(item.status === 1){
                        this.statusChecked = false;
                    }
                    if(item.status === 2){
                        this.statusChecked = true;
                    }

                    axios.get('/api/admin/getReserveFlatInfo',{
                        params:{
                            flatId: item.flat_id
                        }
                    }).then(response=>{
                        this.itemFlat = response.data.flatName
                        this.itemFlatFloor = response.data.floorName
                        this.itemFlatHouse = response.data.houseName
                        this.itemFlatObject = response.data.objectName
                    });
                }
                if(this.showItem === 2){
                    this.itemId = item.id;
                    this.itemName = item.name;
                    this.itemNumber = item.number;
                    this.itemFlatId = item.office_id;

                    if(item.status === 1){
                        this.statusChecked = false;
                    }
                    if(item.status === 2){
                        this.statusChecked = true;
                    }

                    axios.get('/api/admin/getReserveOfficeInfo',{
                        params:{
                            officeId: item.office_id
                        }
                    }).then(response=>{
                        this.itemFlat = response.data.flatName
                        this.itemFlatFloor = response.data.floorName
                        this.itemFlatHouse = response.data.houseName
                        this.itemFlatObject = response.data.objectName
                    });
                }
                if(this.showItem === 3){
                    this.itemId = item.id;
                    this.itemName = item.name;
                    this.itemNumber = item.number;
                    this.itemFlatId = item.pantry_id;

                    if(item.status === 1){
                        this.statusChecked = false;
                    }
                    if(item.status === 2){
                        this.statusChecked = true;
                    }

                    axios.get('/api/admin/getReservePantryInfo',{
                        params:{
                            pantryId: item.pantry_id
                        }
                    }).then(response=>{
                        this.itemFlat = response.data.flatName
                        this.itemFlatFloor = response.data.floorName
                        this.itemFlatHouse = response.data.houseName
                        this.itemFlatObject = response.data.objectName
                    });
                }

            },
            changeStatus(){
                axios.get('/api/admin/updateStatusReserve', {
                    params: {
                        reserveId: this.itemId,
                        statusId: this.statusChecked,
                        itemShow: this.showItem,
                        selectStatus: this.selectStatus,
                    }
                })
                    .then(response=>{
                        this.hasMsg = true;
                        this.sMsg = response.data.msg;
                        this.reserves = response.data.reserves
                        this.dialog = false
                    })
            },
            deleteCall(id){
                if(window.confirm('Вы действительно хотите удалить это здание?'))
                {
                    axios.delete('/api/admin/deleteReserve/',{
                        params: {
                            reserveId: id,
                            itemShow: this.showItem,
                        }
                    })
                        .then(response=>{
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                            this.reserves = response.data.reserves;
                        })
                        .catch(error=>{
                            this.hasError = true;
                            this.sMsg = error.response.data.msg;
                        })
                }
            },
            fetch(){
                axios.get('/api/admin/getReserves', {
                    params: {
                        statusId: this.selectStatus,
                        showItem: this.showItem
                    }
                })
                    .then(response=>{
                        this.reserves = response.data.reserves
                    })
            }
        },
        created() {
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
