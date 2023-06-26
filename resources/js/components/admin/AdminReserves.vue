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
<!--                    <v-spacer>-->
<!--                    </v-spacer>-->
<!--                    <v-col cols="4">-->
<!--                        <v-text-field-->
<!--                            v-model="search"-->
<!--                            append-icon="mdi-search"-->
<!--                            label="Найти"-->
<!--                            single-line-->
<!--                            hide-details-->
<!--                        ></v-text-field>-->
<!--                    </v-col>-->
                </v-row>
            </v-card-title>

            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left">Номер</th>
                            <th class="text-center">ФИО</th>
                            <th class="text-center">Статус</th>
                            <th class="text-center">Объект</th>
                            <th class="text-center">Дом</th>
                            <th class="text-center">Тип</th>
                            <th class="text-center">№</th>
                            <th class="text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in reserves" :key="item.id" class="tr-row">
                        <td class="text-left">{{item.number}}</td>
                        <td class="text-center">{{item.name}}</td>
                        <td class="text-center" v-if="item.status === 0">Новый</td>
                        <td class="text-center" v-if="item.status === 1">Просмотрен</td>
                        <td class="text-center">{{item.reservable.floorr.house.object.name}}</td>
                        <td class="text-center">{{item.reservable.floorr.house.name}}</td>
                        <td class="text-center">{{item.reservable_type}}</td>
                        <td class="text-center">{{item.reservable.name}}</td>
                        <td class="text-center">
                            <v-icon @click="edit(item)" class="crud-icon-show" size="18" v-on="on">mdi-eye-outline</v-icon>
                            <v-icon class="crud-icon-delete" @click="dlt(item.id)" size="18">mdi-delete</v-icon>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card>

        <v-dialog v-model="dialog" width="500">
            <v-card>
                <v-card-title class="headline grey lighten-2" primary-title>
                    <div v-if="itemReservableType === 'офис'">
                        Бронь офиса №{{itemReservableId}}
                    </div>
                    <div v-if="itemReservableType === 'квартира'">
                        Бронь квартиры №{{itemReservableId}}
                    </div>
                    <div v-if="itemReservableType === 'кладвка'">
                        Бронь кладовки №{{itemReservableId}}
                    </div>
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field disabled :value="itemNumber" label="Номер телефона"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field disabled :value="itemName" label="ФИО"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-checkbox
                                v-model="itemStatus"
                                label="Просмотрен"
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="upd(itemId)">Изменить</v-btn>
                    <v-btn color="primary" text @click="dialog = false">Закрыть</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


    </div>
</template>

<script>
    export default {
        name: "AdminReserves",
        data(){
            return{
                reserves: [],
                status: [
                    { id: null, name: 'Все' },
                    { id: 0, name: 'Новые' },
                    { id: 1, name: 'Просмотренные' },
                ],
                show: [
                    { id: null, name: 'Все' },
                    { id: "flat", name: 'Квартиры' },
                    { id: "office", name: 'Офисы' },
                    { id: "pantry", name: 'Кладовки' },
                ],
                showItem: null,
                selectStatus: null,
                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                dialog: false,

                itemId: null,
                itemName: null,
                itemNumber: null,
                itemStatus: null,
                itemReservableType: null,
                itemReservableId: null,
                itemReservableName: null,
                itemReservableHouseName: null,
                itemReservableObjectName: null,
            }
        },
        methods:{
            fetch(){
                this.$http.get('/api/admin/reserves', {
                    params: {
                        statusId: this.selectStatus,
                        showItem: this.showItem
                    }
                })
                    .then(response => {
                        this.reserves = response.data.reserves;
                    })
            },
            dlt(id){
                function dltImgBloc(item) {
                    item.parentNode.parentNode.classList.add('disable')
                    // item.parentNode.parentNode.parentNode.removeChild(item);
                }

                var imgBlock = event.currentTarget;

                if(window.confirm('Вы действительно хотите удалить это здание?'))
                {
                    this.$http.delete('/api/admin/reserves/' + id)
                        .then(response=>{
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                            // this.reserves = response.data.reserves;
                            dltImgBloc(imgBlock);
                        })
                        .catch(error=>{
                            this.hasError = true;
                            this.sMsg = error.response.data.msg;
                        })
                }
            },
            edit(item){
                this.dialog = true;

                this.itemId = item.id;
                this.itemName = item.name;
                this.itemNumber = item.number;
                this.itemStatus = item.status;
                this.itemReservableType = item.reservable_type;
                this.itemReservableId = item.reservable_id;
                this.itemReservableName = item.reservable.name;
                this.itemReservableHouseName = item.reservable.floorr.house.name;
                this.itemReservableObjectName = item.reservable.floorr.house.object.name;
            },
            upd(id){
                const formData = new FormData()
                formData.append('_method', 'PUT')
                formData.append('status', this.itemStatus)

                this.$http.post('/api/admin/reserves/' + id, formData )
                    .then(response=>{
                        this.hasMsg = true;
                        this.sMsg = response.data.msg;
                        this.fetch();
                    })
                    .catch(error=>{
                        this.hasError = true;
                        this.sMsg = error.response.data.msg;
                    });
            }
        },
        mounted() {
            this.fetch();
        }
    }
</script>

<style scoped>
    .tr-row{

    }
    .tr-row.disable{
        display: none;
    }
</style>
