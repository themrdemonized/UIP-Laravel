<template>
    <div>
        <div v-if="hasMsg">
            <v-alert v-model="hasMsg" text dismissible type="success">
                {{sMsg}}
            </v-alert>
        </div>

        <div v-if="hasError">
            <v-alert v-model="hasError" text dismissible type="error">
                I'm a error alert.
            </v-alert>
        </div>

        <v-card>
            <v-card-title>
                Новости
                <v-spacer></v-spacer>

                <v-btn :to="{name: 'adminNewsCreate'}" class="primary">
                    Добавить новость
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
                        <th class="text-left">Создатель</th>
                        <th class="text-right">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in filteredList" :key="item.id">
                        <td>{{ item.title }}</td>
                        <td>{{ item.user.name }}</td>
                        <td class="text-right">
                            <router-link class="crud-icon-link" :to="{name: 'adminNewsUpdate', params: {id: item.id}}"><v-icon class="crud-icon-edit" size="18">mdi-pencil</v-icon></router-link>
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
        name: "AdminNew",
        props:{
            successMsg: ''
        },
        data(){
            return {
                search: '',
                news: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;

                return this.news.filter(function (elem) {
                    if(comp==='') return true;
                    else return elem.title.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            fetch(){
                axios.get('/api/admin/news/')
                    .then(response=>{
                        this.news = response.data.news
                    })
            },
            dlt(id){
                if(window.confirm('Вы действительно хотите удалить эту новость?'))
                {
                    axios.delete('/api/admin/news/' + id)
                        .then(response=>{
                            this.news = response.data.news;
                            this.hasMsg = true;
                            this.sMsg = response.data.msg;
                        })
                        .catch(error=>{
                            this.hasError = true;
                            this.sMsg = error.response.data.msg;
                        })
                }
            },
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
