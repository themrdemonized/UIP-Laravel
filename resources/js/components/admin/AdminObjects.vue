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
                Объекты
                <v-spacer></v-spacer>
                <v-btn class="primary" :to="{name: 'adminObjectCreate'}">Добавить объект</v-btn>
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
                            <router-link class="crud-icon-link" :to="{name: 'adminObjectShow', params: {id: item.id, objectName: item.name}}"><v-icon class="crud-icon-show" size="18">mdi-eye-outline</v-icon></router-link>
                            <router-link class="crud-icon-link" :to="{name: 'adminObjectEdit', params: {id: item.id}}"><v-icon class="crud-icon-edit" size="18">mdi-pencil</v-icon></router-link>
                            <router-link class="crud-icon-link" to="#"><v-icon @click="dlt(item.id)" class="crud-icon-delete" size="18">mdi-delete</v-icon></router-link>
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
        name: "AdminObject",
        props:{
          successMsg: ''
        },
        data(){
            return {
                search: '',
                objects: [],

                hasMsg: false,
                sMsg: this.successMsg,
                hasError: false,
                err: '',
            }
        },
        computed:{
            filteredList: function(){
                var comp = this.search;
                return this.objects.filter(function (elem) {

                    if(comp==='') return true;
                    else return elem.name.toLowerCase().indexOf(comp.toLowerCase()) > -1;
                })
            }
        },
        methods:{
            fetch(){
                axios.get('/api/objects')
                    .then(response=>{
                    this.objects = response.data.objects
                })
            },
            dlt(id){
                if(window.confirm('Вы действительно хотите удалить этот объект?'))
                {
                    axios.delete('/api/admin/deleteObject',{
                        params: {
                            id: id
                        }
                    })
                        .then(response=>{
                            this.objects = response.data.objects;
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

</style>
