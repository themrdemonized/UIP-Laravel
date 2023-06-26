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
                    <v-col cols="2" style="display: flex; align-items: center; margin-right: 5rem">
                        Обратный звонок
                    </v-col>
                    <v-col cols="2">
                        <v-select
                            :items="status"
                            item-text="name"
                            item-value="id"
                            v-model="selectStatus"
                            label="Показать"
                            @change="showStatus"
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
                            <th class="text-center">Статус</th>
                            <th class="text-right">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id + item.number" >
                        <td @click="showModal(item.id)" class="text-left">{{ item.number }}</td>
                        <td @click="showModal(item.id)" class="text-center">{{ item.name }}</td>
                        <td @click="showModal(item.id)" v-if="item.status === 1" class="text-center">Новый</td>
                        <td @click="showModal(item.id)" v-if="item.status === 2" class="text-center">Просмотрен</td>
                        <td class="text-right">
                                <v-dialog v-model="dialog" persistent max-width="600px">
                                    <template v-slot:activator="{ on }">
                                        <v-icon @click="showModal(item)" class="crud-icon-show" size="18" v-on="on">mdi-eye-outline</v-icon>
                                    </template>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">Звонок</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
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
                statusChecked: false,

                status: [
                    { id: null, name: 'Все'},
                    { id: 1, name: 'Новые'},
                    { id: 2, name: 'Просмотренные'},
                ],
                selectStatus: null,

                search: '',
                headers: [
                    { text: 'Название', align: 'left', sortable: false, value: 'name' },
                    { text: 'Actions', value: 'action', sortable: false },
                ],

                calls: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.calls.filter(function (elem) {
                    if(comp==='') return true;
                    else return elem.name.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            showModal(item){
                this.itemId = item.id;
                this.itemName = item.name;
                this.itemNumber = item.number;

                if(item.status === 1){
                    this.statusChecked = false;
                }
                if(item.status === 2){
                    this.statusChecked = true;
                }
            },
            changeStatus(){
                const formData = new FormData()
                formData.append('_method', 'PUT')
                formData.append('statusId', this.statusChecked)

                axios.post('/api/admin/calls/' + this.itemId, formData)
                    .then(response=>{
                        this.hasMsg = true;
                        this.sMsg = response.data.msg;
                        this.calls = response.data.calls
                    })
            },
            showStatus(){
                axios.get('/api/admin/calls', {
                    params: {
                        statusId: this.selectStatus
                    }
                })
                    .then(response=>{
                        this.calls = response.data.calls
                    })
            },
            deleteCall(id){
                if(window.confirm('Вы действительно хотите удалить этот звонок?'))
                {
                    axios.delete('/api/admin/calls/' + id)
                        .then(response=>{
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                            this.calls = response.data.calls;
                        })
                        .catch(error=>{
                            this.hasError = true;
                            this.sMsg = error.response.data.msg;
                        })
                }
            },
            fetch(){
                axios.get('/api/admin/calls')
                    .then(response=>{
                        this.calls = response.data.calls
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
