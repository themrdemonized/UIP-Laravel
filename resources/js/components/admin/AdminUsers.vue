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
                Пользователи
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-search"
                    label="Найти"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Имя</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Роль</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in filteredList" :key="item.id">
                            <td>{{ item.name }}</td>
                            <td>{{ item.email }}</td>

                            <td v-if="item.role === 1 ">Пользователь</td>
                            <td v-if="item.role === 2 ">Менедженр</td>
                            <td v-if="item.role === 3 ">Админитсратор</td>

                            <td class="text-right">
                                <v-icon @click="show(item.id)" class="crud-icon-show" size="18">mdi-eye-outline</v-icon>
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
        name: "AdminUsers",
        props:{
            successMsg: {
                type: String,
                default: null
            }
        },
        data(){
            return {
                search: '',
                users: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.users.filter(function (elem) {

                    if(comp==='') return true;
                    else return elem.email.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            fetch(){
                axios.get('/api/admin/getUsers')
                    .then(response=>{
                        this.users = response.data.users
                })
            },
            show(id){
                this.$router.push({name: 'adminUserShow', params: { id: id } })
            },
            dlt(id){
                if(window.confirm('Вы действительно хотите удалить этого пользователя?'))
                {
                    axios.delete('/api/admin/deleteUser/',{
                        params: {
                            userId: id
                        }
                    })
                        .then(response=>{
                            this.users = response.data.users;
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                            this.floors = response.data.floors;
                        })
                        .catch(error=>{
                            this.hasError = true;
                            this.err = error.response.data.msg;
                        })
                }
            }
        },
        created() {
            this.fetch();
        },
        mounted() {
            if(this.sMsg !== null){
                this.hasMsg = true;
            }
        }
    }
</script>

<style scoped>

</style>
