<template>
    <div>
        <div v-if="hasMsg">
            <v-alert v-model="hasMsg" text dismissible type="success">
                {{sMsg}}
            </v-alert>
        </div>

        <div v-if="hasError">
            <v-alert v-model="hasError" text dismissible type="error">
                {{err}}
            </v-alert>
        </div>

        <v-card>
            <v-card-title>
                Офисы
                <v-spacer></v-spacer>

                <v-btn :to="{name: 'adminOfficeCreate'}" class="primary">
                    Добавить офис
                </v-btn>
            </v-card-title>
            <v-card-subtitle>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-search"
                    label="Найти"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-subtitle>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Название</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td class="text-right">
                            <router-link class="crud-icon-link" :to="{name: 'adminOfficeUpdate', params: {id: item.id}}"><v-icon class="crud-icon-edit" size="18">mdi-pencil</v-icon></router-link>
                            <v-icon @click="dlt(item.id)" class="crud-icon-delete" size="18">mdi-delete</v-icon>
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
        name: "AdminOffices",
        props:{
            successMsg: ''
        },
        data(){
            return {
                search: '',
                offices: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.offices.filter(function (elem) {

                    if(comp==='') return true;
                    else return elem.name.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            fetch(){
                axios.get('/api/admin/getOffices')
                    .then(response=>{
                        this.offices = response.data.offices
                    })
            },
            dlt(id){
                if(window.confirm('Вы действительно хотите удалить этот офис?'))
                {
                    axios.delete('/api/admin/deleteOffice/',{
                        params: {
                            officeId: id
                        }
                    })
                        .then(response=>{
                            this.offices = response.data.offices;
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                        })
                }
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
